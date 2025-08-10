<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ReservationRequest;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Models\TicketConfig;
use App\Services\EasypayService;
use App\Services\NiceApiService;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class ReservationController extends Controller
{
    public function __construct(
        private NiceApiService $nice_service,
        private ReservationService $reservation_service,
        private EasypayService $easypay_service,
    ) {
        if (! $this->is_dev()) {
            abort(404);
        }
    }

    #[Get('reservation/auth', 'ko.reservation.auth')]
    #[Get('en/reservation/auth', 'en.reservation.auth')]
    public function auth(Request $request)
    {
        if (Auth::guard('web')->check()) {
            if ($request->session()->has('nice_date')) {
                $request->session()->remove('nice_data');

                return $this->to_route('reservation.form');
            }
        }

        return view('front.reservation.auth', [
            'nice_url' => $this->nice_service->url,
            'nice_data' => $this->nice_service->getFormData('reservation.form'),
        ]);
    }

    #[Get('reservation', 'ko.reservation.form')]
    #[Get('en/reservation', 'en.reservation.form')]
    public function form(Request $request)
    {
        if ($request->has('static')) {
            return view('reservation.form');
        }

        $is_guest = ! Auth::guard('web')->check();

        if ($is_guest && app()->getLocale() === 'en') {
            return $this->to_route('login');
        }

        if ($is_guest && ! $request->session()->has('nice_data')) {
            return $this->to_route('reservation.auth');
        }

        $config = TicketConfig::latest()->first();
        $tickets = Ticket::where('status', true)->orderBy('order_idx')->latest()->get(['id', 'title']);

        $off_message = $this->reservation_service->get_off_message();

        Inertia::setRootView('front.reservation.form-react');

        return Inertia::render('reservation', compact('config', 'tickets', 'off_message'));
    }

    /**
     * CSRF 프로텍션 예외 처리 필요
     * bootstrap/app.php 에 해당 코드 있습니다.
     * 라우팅 변경시 해당 파일도 같이 변경해주세요 !!
     */
    #[Post('reservation', 'ko.reservation.store')]
    #[Post('en/reservation', 'en.reservation.store')]
    public function store(ReservationRequest $request)
    {
        try {
            $ticket = Ticket::find($request->input('ticket'));

            $data = $request->validated();
            $data['visitors'] = array_filter($data['visitors'] ?? []);

            $select_date = new Carbon($data['select_date'] . ' ' . $data['select_time'] . ':00');

            $reservation = new Reservation();

            $reservation->user_id = 0;
            $reservation->ticket_id = $ticket->id;
            $reservation->locale = $this->get_locale();
            $reservation->code = $select_date->format('Ymd') . '-' . sprintf('%05d', Reservation::withTrashed()->where('select_date', $data['select_date'])->count() + 1);
            $reservation->select_date = $select_date->format('Y-m-d');
            $reservation->select_time = $select_date->format('H:i:s');
            $reservation->use_docent = $data['use_docent'];
            $reservation->visitors = $data['visitors'] ?? [];
            $reservation->total_visitors = 0;
            $reservation->amount = 0;

            foreach ($reservation->visitors as $key => $count) {
                $reservation->total_visitors += (int) $count;
                $reservation->amount += $count * ((int) $ticket->price[$key][$this->reservation_service->is_off($select_date) ? 'off' : 'peak']);
            }

            if (Auth::check()) {
                $current_user = $request->user();
                $reservation->user_id = $current_user->id;
                $reservation->user_name = $current_user->name;
                $reservation->user_email = $current_user->email;
                $reservation->user_mobile = str_replace('-', '', $current_user->mobile);
                $reservation->user_birth = $current_user->birth;
                $reservation->user_gender = $current_user->gender === null ? '' : ($current_user->gender ? '남자' : '여자');
            } else {
                $nice_data = $request->session()->get('nice_data');

                $reservation->user_name = $nice_data['name'];
                $reservation->user_mobile = str_replace('-', '', $nice_data['mobile']);
                $reservation->user_birth = $nice_data['birth'];
                $reservation->user_gender = $nice_data['gender'] ? '남자' : '여자';
            }

            if (! $this->reservation_service->can_reservation($reservation)) {
                throw new \Exception();
            }

            $reservation->save();

            return $this->to_route('reservation.payment.index', compact('reservation'));
        } catch (\Exception $e) {
            return $this->to_route('reservation.form')->with('error-message', __('jt.CA-09'));
        }
    }

    #[Get('reservation/{reservation}/success', 'ko.reservation.success')]
    #[Get('en/reservation/{reservation}/success', 'en.reservation.success')]
    public function success(Request $request, Reservation $reservation)
    {
        if (! $reservation->is_own() || empty($reservation->paid_at)) {
            abort(404);
        }

        return view('front.reservation.success', compact('reservation'));
    }

    #[Get('reservation/{reservation}/payment', 'ko.reservation.payment.index')]
    #[Get('en/reservation/{reservation}/payment', 'en.reservation.payment.index')]
    public function payment(Request $request, Reservation $reservation)
    {
        if (! $reservation->is_own()) {
            abort(404);
        }

        if (! empty($reservation->paid_at)) {
            return $this->to_route('reservation.success', compact('reservation'));
        }

        return view('front.reservation.payment', compact('reservation'));
    }

    /**
     * CSRF 프로텍션 예외 처리 필요
     * bootstrap/app.php 에 해당 코드 있습니다.
     * 라우팅 변경시 해당 파일도 같이 변경해주세요 !!
     */
    #[Post('reservation/{reservation}/payment', 'ko.reservation.payment.store')]
    #[Post('en/reservation/{reservation}/payment', 'en.reservation.payment.store')]
    public function payment_store(Request $request, Reservation $reservation)
    {
        if ($reservation->created_at->diffInMinutes(Carbon::now()) > 10) {
            return [
                'success' => false,
                'message' => __('jt.CA-07'),
                'redirect_to' => jt_route('reservation.form'),
            ];
        }

        if (! $reservation->is_own()) {
            return [
                'success' => false,
                'redirect_to' => jt_route('reservation.form'),
            ];
        }

        if (! is_null($reservation->paid_at)) {
            return [
                'success' => false,
                'redirect_to' => jt_route('reservation.success', compact('reservation')),
            ];
        }

        if (! $this->reservation_service->can_reservation($reservation)) {
            return [
                'success' => false,
                'message' => __('jt.CA-09'),
                'redirect_to' => jt_route('reservation.form'),
            ];
        }

        if ($reservation->amount === 0) {
            $reservation->update([
                'paid_at' => Carbon::now(),
                'paid_method' => '00',
            ]);

            $this->reservation_service->send_success($reservation);

            return [
                'success' => false,
                'redirect_to' => jt_route('reservation.success', compact('reservation')),
            ];
        }

        $payment = (string) $request->input('payment', '11');
        $payment = in_array($payment, ['11', '21']) ? $payment : '11';

        $is_mobile = 'mobile' === $request->input('device', 'pc');

        $result = $this->easypay_service->getAuthPageUrl($reservation, $payment, $is_mobile);

        return [
            'success' => true,
            'redirect_to' => $result,
        ];
    }

    /**
     * CSRF 프로텍션 예외 처리 필요
     * bootstrap/app.php 에 해당 코드 있습니다.
     * 라우팅 변경시 해당 파일도 같이 변경해주세요 !!
     */
    #[Post('reservation/{reservation}/payment/callback', 'ko.reservation.payment.callback')]
    #[Post('en/reservation/{reservation}/payment/callback', 'en.reservation.payment.callback')]
    public function payment_callback(Request $request, Reservation $reservation)
    {
        $error_message = null;

        if ('W002' === $request->get('resCd')) {
            return "
            <script>
                window.close();
            </script>
            ";
        }

        if (! $reservation->is_own() || $reservation->created_at->diffInMinutes(Carbon::now()) > 2) {
            $error_message = __('jt.CA-10');
        }

        if (! $this->reservation_service->can_reservation($reservation)) {
            $error_message = __('jt.CA-09');
        }

        if (! empty($error_message)) {
            $redirect = jt_route('reservation.form');

            return "
            <script>
            alert('{$error_message}');

            if (window.opener) {
                window.opener.document.location.href = '{$redirect}';
                window.close();
            } else {
                document.location.href = '{$redirect}';
            }
            </script>
            ";
        }

        if (is_null($reservation->paid_at)) {
            $authorization_id = $request->input('authorizationId');
            $result = $this->easypay_service->approval($reservation, $authorization_id);

            $reservation->update([
                'paid_id' => $result['pgCno'],
                'paid_method' => $result['paymentInfo']['payMethodTypeCode'] ?? null,
                'paid_at' => Carbon::now(),
            ]);

            $this->reservation_service->send_success($reservation);
        }

        $redirect = jt_route('reservation.success', compact('reservation'));

        return "
        <script>
        if (window.opener) {
            window.opener.document.location.href = '{$redirect}';
            window.close();
        } else {
            document.location.href = '{$redirect}';
        }
        </script>
        ";
    }
}
