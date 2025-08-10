<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\EasypayService;
use App\Services\NiceApiService;
use App\Services\ReservationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;

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

    #[Get('member/reservation/auth', 'ko.member.reservation.auth')]
    #[Get('en/member/reservation/auth', 'en.member.reservation.auth')]
    public function auth(Request $request)
    {
        if ($request->session()->get('nice_data')) {
            return $this->to_route('member.reservation.list');
        }

        return view('front.reservation.auth', [
            'nice_url' => $this->nice_service->url,
            'nice_data' => $this->nice_service->getFormData('member.reservation.list'),
        ]);
    }

    #[Get('member/reservation', 'ko.member.reservation.list')]
    #[Get('en/member/reservation', 'en.member.reservation.list')]
    public function list(Request $request)
    {
        $filter_status = $request->get('status', '');
        $filter_used = $request->has('filter_used');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $filter_period = $request->get('period');

        if ($filter_period) {
            if ('all' === $filter_period) {
                $start_date = '';
                $end_date = '';
            } elseif ('w' === $filter_period) {
                $start_date = Carbon::today()->format('Y-m-d');
                $end_date = Carbon::today()->add('+1 week')->format('Y-m-d');
            } elseif ('m' === $filter_period) {
                $start_date = Carbon::today()->format('Y-m-d');
                $end_date = Carbon::today()->add('+1 month')->format('Y-m-d');
            } elseif ('y' === $filter_period) {
                $start_date = Carbon::today()->format('Y-m-d');
                $end_date = Carbon::today()->add('+1 year')->format('Y-m-d');
            }
        }

        $is_guest = ! Auth::guard('web')->check();

        if ($is_guest && app()->getLocale() === 'en') {
            return $this->to_route('login');
        }

        if ($is_guest && ! $request->session()->get('nice_data')) {
            return $this->to_route('member.reservation.auth');
        }

        $nice_data = $request->session()->get('nice_data');

        $user_name = $is_guest ? $nice_data['name'] : $request->user('web')->name;

        $query = Reservation::query();

        $query->whereHas('ticket', function (Builder $query) {
            $query->withoutTrashed();
        });

        $query->whereNotNull('paid_at');

        if ($is_guest) {
            $query->where('user_id', 0);
            $query->where('user_mobile', str_replace('-', '', $nice_data['mobile']));
        } else {
            $query->where('user_id', $request->user('web')->id);
        }

        if ('cancel' === $filter_status) {
            $query->whereNotNull('canceled_at');
        } else {
            if ($filter_used) {
                $query->whereNull('used_at');
            }

            $query->whereNull('canceled_at');
        }

        if (! empty($start_date)) {
            $query->where('select_date', '>=', $start_date);
        }

        if (! empty($end_date)) {
            $query->where('select_date', '<=', $end_date);
        }

        // $query->orderByDesc('select_date')->orderByDesc('select_time')->latest();
        $query->orderByDesc('paid_at');

        $reservations = $query->paginate(10);

        return view('front.reservation.list', compact(
            'is_guest',
            'user_name',
            'reservations',
            'filter_status',
            'filter_used',
            'filter_period',
            'start_date',
            'end_date',
        ));
    }

    #[Delete('member/reservation/{reservation}', 'ko.member.reservation.cancel')]
    #[Delete('en/member/reservation/{reservation}', 'en.member.reservation.cancel')]
    public function cancel(Request $request, Reservation $reservation)
    {
        if ($reservation->is_own()) {
            $revise_amount = $reservation->amount;

            if ($reservation->amount > 0) {
                $diff = (int) Carbon::today()->diffInDays($reservation->select_date);

                if ($diff <= 1) {
                    return $this->to_route('member.reservation.list')->with('cancel-message', __('jt.CA-04'));
                }

                if (2 === $diff) {
                    $revise_amount = $reservation->amount - ceil($reservation->amount * 0.3);
                }

                $result = $this->easypay_service->cancel($reservation, $revise_amount, $request->ip());

                if ('0000' !== $result['resCd']) {
                    return $this->to_route('member.reservation.list')->with('cancel-message', $result['resMsg']);
                }

            }

            $reservation->update([
                'canceled_amount' => $revise_amount,
                'canceled_at' => Carbon::now(),
            ]);

            $this->reservation_service->send_cancel($reservation);

            return $this->to_route('member.reservation.list', ['status' => 'cancel'])->with('cancel-message', __('jt.CA-02'));
        }

        return $this->to_route('member.reservation.list');
    }

    #[Get('member/reservation/{reservation}', 'ko.member.reservation.qrcode')]
    #[Get('en/member/reservation/{reservation}', 'en.member.reservation.qrcode')]
    public function qrcode(Request $request, mixed $reservation)
    {
        $reservation = Reservation::find($reservation);

        return view('front.reservation.qrcode', compact('reservation'));
    }
}
