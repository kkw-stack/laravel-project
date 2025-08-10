<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReservationCancelRequest;
use App\Models\Reservation;
use App\Services\EasypayService;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Patch;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('reservation')]
class ReservationController extends Controller
{
    public function __construct(
        private EasypayService $easypay,
    ) {
    }

    #[Get('manage', 'admin.reservation.manage.list')]
    public function manage_list(Request $request)
    {
        $reservation = null;
        $select_date = $request->get('select_date', Carbon::now()->format('Y-m-d'));

        if ($request->exists('id')) {
            $id = $request->get('id');

            $reservation = Reservation::query()
                ->where('code', $id)
                ->first();

            if (is_null($reservation)) {
                $reservation = false;
            }
        }

        $query = Reservation::query();

        $query->where('select_date', $select_date);
        $query->whereNotNull('used_at');

        $query->orderByDesc('used_at')->latest();

        $reservations = $query->get();

        return view('admin.reservation.ticket', compact(
            'reservation',
            'reservations',
        ));
    }

    #[Post('manage/{reservation}', 'admin.reservation.manage.used')]
    public function manage_store_used(Request $request, Reservation $reservation)
    {
        $reservation->update([
            'used_at' => Carbon::now(),
        ]);

        return to_route('admin.reservation.manage.list')->with('success-message', __('jt.AL-06'));
    }

    #[Patch('manage/{reservation}', 'admin.reservation.manage.cancel')]
    public function manage_store_cancel(Request $request, Reservation $reservation)
    {
        $reservation->update([
            'used_at' => null,
        ]);

        return to_route('admin.reservation.manage.list')->with('success-message', __('jt.AL-10'));
    }

    #[Get('', 'admin.reservation.list')]
    public function list(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $status = $request->query('status');
        $used_status = $request->query('used');
        $ticket_id = (int) $request->query('ticket');
        $payment_method = $request->query('payment_method');
        $docent = $request->exists('docent');
        $search_type = $request->query('search_type', 'code');
        $search = $request->query('search');
        $rpp = (int) $request->query('rpp', 10);
        $sort = $request->query('sort', 'paid_date');

        $reservations = $this->get_search_query($request)->latest()->paginate($rpp);
        $tickets = Ticket::has('reservations')->get();

        return view('admin.reservation.list', compact(
            'start_date',
            'end_date',
            'status',
            'used_status',
            'ticket_id',
            'payment_method',
            'docent',
            'search_type',
            'search',
            'rpp',
            'sort',
            'reservations',
            'tickets',
        ));
    }

    #[Post('', 'admin.reservation.excel')]
    public function excel(Request $request)
    {
        return response(
            view('admin.reservation.excel', [
                'reservations' => $this->get_search_query($request)->latest()->get(),
            ]),
            200,
            [
                'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="medonguale_users_' . date('YmdHis') . '.xls"',
                'Content-Transfer-Encoding' => 'binary',
                'Pragma' => 'no-cache',
                'Expires' => 0,
            ]
        );
    }

    #[Get('{reservation}', 'admin.reservation.detail')]
    public function detail(Request $request, Reservation $reservation)
    {
        $total_count = Reservation::query()
            ->where('user_id', $reservation->user_id)
            ->where('user_mobile', $reservation->user_mobile)
            ->whereNull('canceled_at')
            ->whereNotNull('paid_at')
            ->whereNotNull('used_at')
            ->count();

        return view('admin.reservation.detail', compact('reservation', 'total_count'));
    }

    #[Post('{reservation}', 'admin.reservation.store')]
    public function store(Request $request, Reservation $reservation)
    {
        $data = $request->only('memo');

        if (is_null($reservation->canceled_at)) {
            if (! $request->input('use_status')) {
                $data['used_at'] = null;
            } else {
                $data['used_at'] = ! empty($request->input('used_at')) ? $request->input('used_at') : Carbon::now();
            }
        }

        $reservation->update($data);

        return to_route('admin.reservation.detail', compact('reservation'))->with('success-message', __('jt.ME-02'));
    }

    #[Patch('{reservation}', 'admin.reservation.cancel')]
    public function cancel(ReservationCancelRequest $request, Reservation $reservation)
    {
        $revise_amount = (int) $request->input('cancel_amount');
        $reservation->update([
            'canceled_amount' => $revise_amount,
            'canceled_at' => Carbon::now(),
            'canceled_by' => $request->user('admin')->id,
        ]);

        return to_route('admin.reservation.detail', compact('reservation'))->with('success-message', __('jt.AL-08'));
    }

    private function get_search_query(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $status = $request->query('status');
        $used_status = $request->query('used');
        $ticket_id = (int) $request->query('ticket');
        $payment_method = $request->query('payment_method');
        $docent = $request->exists('docent');
        $search_type = $request->query('search_type', 'code');
        $search = $request->query('search');
        $sort = $request->query('sort', 'paid_date');

        $query = Reservation::query();

        if (! empty($search) && in_array($search_type, ['code', 'user_name', 'user_email', 'user_mobile'])) {
            $query->where($search_type, 'LIKE', '%' . str_replace(' ', '%', $search) . '%');
        }

        if (! empty($start_date)) {
            $query->where('select_date', '>=', $start_date);
        }

        if (! empty($end_date)) {
            $query->where('select_date', '<=', $end_date);
        }

        if ('결제대기' === $status) {
            $query->whereNull('paid_at')->whereNull('canceled_at');
        } elseif ('결제완료' === $status) {
            $query->whereNotNull('paid_at')->whereNull('canceled_at');
        } elseif ('취소' === $status) {
            $query->whereNotNull('canceled_at');
        }

        if (! empty($used_status)) {
            if ('yes' === $used_status) {
                $query->whereNotNull('used_at');
            } elseif ('no' === $used_status) {
                $query->whereNull('used_at');
                $query->where('select_date', '>=', Carbon::today());
            } elseif ('past' === $used_status) {
                $query->where('select_date', '<', Carbon::now()->format('Y-m-d'));
            }
        }

        if (! empty($ticket_id) && Ticket::where('id', $ticket_id)->exists()) {
            $query->where('ticket_id', $ticket_id);
        }

        if (in_array($payment_method, ['00', '11', '21', '22'])) {
            $query->where('paid_method', $payment_method);
        }

        if ($docent) {
            $query->where('use_docent', true);
        }

        if ('paid_date' === $sort) {
            $query->orderByDesc('paid_at');
        }

        $query->orderByDesc('select_date')->orderByDesc('select_time');

        return $query->with([
            'withdraw_user',
            'user',
            'ticket',
        ]);
    }
}
