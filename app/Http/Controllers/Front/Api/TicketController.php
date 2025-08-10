<?php

namespace App\Http\Controllers\Front\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Models\TicketConfig;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\RouteAttributes\Attributes\Get;

class TicketController extends Controller
{
    private TicketConfig $config;

    public function __construct(
        private ReservationService $reservation_service,
    ) {
        if (! $this->is_dev()) {
            abort(404);
        }

        $this->config = TicketConfig::latest()->first();
    }

    #[Get('api/ticket', 'ko.api.ticket.list')]
    #[Get('en/api/ticket', 'en.api.ticket.list')]
    public function list(Request $request)
    {
        $data = Ticket::where('status', true)->orderBy('order_idx')->latest()->get();

        foreach ($data as $idx => $item) {
            $data[$idx]['labels'] = 'en' === $this->get_locale() ? Ticket::PRICE_FOREIGN_LABELS : Ticket::PRICE_LABELS;
        }

        return $data;
    }

    #[Get('api/ticket/config', 'ko.api.ticket.config')]
    #[Get('en/api/ticket/config', 'en.api.ticket.config')]
    public function config(Request $request)
    {
        return TicketConfig::latest()->first();
    }

    #[Get('api/ticket/{ticket}', 'ko.api.ticket.detail')]
    #[Get('en/api/ticket/{ticket}', 'en.api.ticket.detail')]
    public function detail(Request $request, Ticket $ticket)
    {
        $locale = $this->get_locale();

        $data = [
            'title' => $ticket->title[$locale],
            'sector' => $ticket->sector[$locale],
        ];

        return $data;
    }

    #[Get('api/ticket/{ticket}/{date}/time', 'ko.api.ticket.time')]
    #[Get('en/api/ticket/{ticket}/{date}/time', 'en.api.ticket.time')]
    public function time(Request $request, Ticket $ticket, string $date)
    {
        $result = [];

        $date = Carbon::createFromFormat('Y-m-d', $date);

        foreach ($ticket->time_table as $time) {
            $c_time = Carbon::createFromFormat('H:i', $time['time']);

            $result[] = [
                'time' => $c_time->format('H:i'),
                'available' => max(0, intval($time['total']) - $this->reservation_service->get_count_reservated($ticket, $date, $c_time)),
            ];
        }

        if ($ticket->use_night_time_table) {
            $night_start_date = Carbon::createFromFormat('m-d', $ticket->night_start_date)->setYear($date->year);
            $night_end_date = Carbon::createFromFormat('m-d', $ticket->night_end_date)->setYear($date->year);

            if ($date->between($night_start_date, $night_end_date)) {
                foreach ($ticket->night_time_table as $time) {
                    $c_time = Carbon::createFromFormat('H:i', $time['time']);

                    $result[] = [
                        'time' => $c_time->format('H:i'),
                        'available' => max(0, intval($time['total']) - $this->reservation_service->get_count_reservated($ticket, $date, $c_time)),
                    ];
                }
            }
        }

        foreach ($ticket->disable_time_table ?? [] as $item) {
            if ($item['date'] == $date->format('Y-m-d')) {
                $result = array_filter($result, function ($time) use ($item) {
                    return $time['time'] != $item['time'];
                });
            }
        }

        usort($result, function ($a, $b) {
            return strcmp($a['time'], $b['time']);
        });

        return array_values($result);
    }

    #[Get('api/ticket/{ticket}/{date}/{time}/price', 'ko.api.ticket.price')]
    #[Get('en/api/ticket/{ticket}/{date}/{time}/price', 'en.api.ticket.price')]
    public function price(Request $request, Ticket $ticket, string $date, string $time)
    {
        $labels = 'en' === $this->get_locale() ? Ticket::PRICE_FOREIGN_LABELS : Ticket::PRICE_LABELS;
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $time = Carbon::createFromFormat('H:i', $time);

        $is_off = $this->reservation_service->is_off($date);
        $time_table = [];

        foreach ($ticket->price as $key => $price) {
            if (array_key_exists($key, $labels)) {
                $time_table[] = [
                    'name' => $key,
                    'price' => (int) ($price[$is_off ? 'off' : 'peak'] ?? 0),
                    'label' => $labels[$key],
                ];
            }
        }

        $selected_time = [];
        foreach ($ticket->time_table as $item) {
            if (Carbon::createFromFormat('H:i', $item['time'])->format('H:i') == $time->format('H:i')) {
                $selected_time = $item;
            }
        }

        if (empty($selected_time) && $ticket->use_night_time_table) {
            if ($date->between(Carbon::createFromFormat('m-d', $ticket->night_start_date), Carbon::createFromFormat('m-d', $ticket->night_end_date))) {
                foreach ($ticket->night_time_table as $item) {
                    if (Carbon::createFromFormat('H:i', $item['time']) == $time) {
                        $selected_time = $item;
                    }
                }
            }
        }

        $available_count = Reservation::query()
            ->where('user_id', $request->user('web')?->id ?? 0)
            ->where('select_date', $date->format('Y-m-d'))
            ->where('select_time', $time->format('H:i:00'))
            ->whereNotNull('paid_at')
            ->whereNull('canceled_at')
            ->sum('total_visitors');

        return [
            'available_count' => $this->config->max_count - $available_count,
            'use_docent' => (bool) ($selected_time['docent'] ?? false),
            'can_use_docent' => $this->reservation_service->get_docnet_available_count($ticket, $date, Carbon::createFromFormat('H:i', $selected_time['time'])) > 0,
            'time_table' => $time_table,
        ];
    }
}
