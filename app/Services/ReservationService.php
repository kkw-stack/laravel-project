<?php

namespace App\Services;

use App\Jobs\SendReservationCancelSms;
use App\Jobs\SendReservationSuccessSms;
use App\Mail\CancelReservationMail;
use App\Mail\NewReservationMail;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Models\TicketConfig;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReservationService
{
    private TicketConfig $config;
    private string $locale;

    public function __construct()
    {
        $this->config = TicketConfig::latest()->first();
        $this->locale = app()->getLocale();
    }

    public function can_reservation(Reservation $reservation)
    {
        $ticket = $reservation->ticket;
        $select_date = new Carbon($reservation->select_date->format('Y-m-d') . ' ' . $reservation->select_time->format('H:i:s'));

        // 관람권 삭제 또는 비공개 체크
        if (! $ticket->status) {
            return false;
        }

        // 지난 날짜, 당일 예약 체크
        if (Carbon::today()->setTime(23, 59, 59) >= $select_date) {
            return false;
        }

        // 휴관일 체크
        foreach ($this->config->closed_dates ?? [] as $closed_date) {
            if ($select_date->between(Carbon::createFromFormat('Y-m-d', $closed_date['start'])->setTime(0, 0), Carbon::createFromFormat('Y-m-d', $closed_date['end'])->setTime(23, 59, 59))) {
                return false;
            }
        }

        // 요일 체크
        if (in_array($select_date->format('w'), $this->config->closed_weekday ?? [])) {
            return false;
        }

        // 예약 불가 날짜/시간 체크
        if (! empty($ticket->disable_time_table)) {
            $disable_time_table = array_map(fn ($data) => (new Carbon($data['date'] . ' ' . $data['time'] . ':00'))->format('Y-m-d H:i:s'), $ticket->disable_time_table);

            if (in_array($select_date->format('Y-m-d H:i:s'), $disable_time_table)) {
                return false;
            }
        }

        $time_data = null;

        // 관람 시간 체크
        if (! in_array($select_date->format('H:i'), array_column($ticket->time_table, 'time'))) {
            // 야간 관람 사용 여부 체크
            if (! $ticket->use_night_time_table) {
                return false;
            }

            // 야간 관람 날짜 체크
            if (! $select_date->between(Carbon::createFromFormat('m-d', $ticket->night_start_date)->setYear($select_date->year), Carbon::createFromFormat('m-d', $ticket->night_end_date)->setYear($select_date->year))) {
                return false;
            }

            // 야간 관람 시간 체크
            if (! in_array($select_date->format('H:i'), array_column($ticket->night_time_table, 'time'))) {
                return false;
            }

            $time_data = $ticket->night_time_table[array_search($select_date->format('H:i'), array_column($ticket->night_time_table, 'time'))] ?? null;
        } else {
            $time_data = $ticket->time_table[array_search($select_date->format('H:i'), array_column($ticket->time_table, 'time'))] ?? null;
        }

        $count_query = $this->get_reservation_count_query($ticket, $select_date);

        if ($reservation->id > 0) {
            $count_query->whereNot('id', $reservation->id);
        }

        $reservation_count = (int) $count_query->sum('total_visitors');
        $docent_count = (int) $count_query->where('use_docent', true)->sum('total_visitors');

        // 방문 인원 체크
        if (max(0, intval($time_data['total'] ?? 0) - $reservation_count) <= 0) {
            return false;
        }

        // 중복 구매 체크
        $reservated_count = (int) Reservation::query()
            ->where('user_id', $reservation->user_id)
            ->where('user_mobile', $reservation->user_mobile)
            ->where('select_date', $reservation->select_date)
            ->where('select_time', $reservation->select_time)
            ->whereNull('canceled_at')
            ->whereNotNull('paid_at')
            ->sum('total_visitors');
        if ($this->config->max_count - $reservated_count - $reservation->total_visitors < 0) {
            return false;
        }

        // 정원 해설 체크
        if ($reservation->use_docent && max(0, $this->config->max_docent - $docent_count) <= 0) {
            return false;
        }

        return true;
    }

    public function send_success(Reservation $reservation)
    {
        if ($reservation->user_email) {
            Mail::to($reservation->user_email)->locale($this->locale)->send(new NewReservationMail($reservation));
        }

        if ($reservation->user_mobile) {
            SendReservationSuccessSms::dispatch($reservation);
        }
    }

    public function send_cancel(Reservation $reservation)
    {
        if ($reservation->user_email) {
            Mail::to($reservation->user_email)->locale($this->locale)->send(new CancelReservationMail($reservation));
        }

        if ($reservation->user_mobile) {
            SendReservationCancelSms::dispatch($reservation);
        }
    }

    public function get_count_reservated(Ticket $ticket, Carbon $date, Carbon $time) : int
    {
        $query = $this->get_reservation_count_query($ticket, new Carbon($date->format('Y-m-d') . ' ' . $time->format('H:i:00')));
        $result = $query->sum('total_visitors');

        return $result;
    }

    public function get_docnet_available_count(Ticket $ticket, Carbon $date, Carbon $time) : int
    {
        $query = $this->get_reservation_count_query($ticket, new Carbon($date->format('Y-m-d') . ' ' . $time->format('H:i:00')));
        $query->where('use_docent', true);

        return max(0, $this->config->max_docent - $query->sum('total_visitors'));
    }

    public function is_off(Carbon $date) : bool
    {
        $is_off = false;

        $summer_off = $this->get_summer_period();
        $winter_off = $this->get_winter_period();

        if (! empty($summer_off)) {
            $is_off = $is_off || $this->is_date_between($date, $summer_off[0]->setYear($date->year), $summer_off[1]->setYear($date->year));
        }

        if (! empty($winter_off)) {
            $is_off = $is_off || $this->is_date_between($date, $winter_off[0]->setYear($date->year), $winter_off[1]->setYear($date->year));
        }

        return $is_off;
    }

    private function is_date_between(Carbon $date, Carbon $start, Carbon $end) : bool
    {
        if ($start > $end) {
            return $date >= $start || $date <= $end;
        } else {
            return $date >= $start && $date <= $end;
        }
    }

    public function get_off_message() : string
    {
        $result = [];
        $month = 'en' === $this->locale ? 'F' : 'n';

        $summer_off = $this->get_summer_period();
        if (! empty($summer_off)) {
            $result[] = __('front.reservation.form.date.off.summer', ['START_MONTH' => $summer_off[0]->format($month), 'START_DAY' => $summer_off[0]->format('j'), 'END_MONTH' => $summer_off[1]->format($month), 'END_DAY' => $summer_off[1]->format('j')]);
        }

        $winter_off = $this->get_winter_period();
        if (! empty($winter_off)) {
            $result[] = __('front.reservation.form.date.off.winter', ['START_MONTH' => $winter_off[0]->format($month), 'START_DAY' => $winter_off[0]->format('j'), 'END_MONTH' => $winter_off[1]->format($month), 'END_DAY' => $winter_off[1]->format('j')]);
        }

        return implode(', ', $result);
    }

    private function get_summer_period() : array
    {
        if (! empty($this->config->summer_start) && ! empty($this->config->summer_end)) {
            return [
                Carbon::createFromFormat('m-d', $this->config->summer_start),
                Carbon::createFromFormat('m-d', $this->config->summer_end),
            ];
        }

        return [];
    }

    private function get_winter_period() : array
    {
        if (! empty($this->config->winter_start) && ! empty($this->config->winter_end)) {
            return [
                Carbon::createFromFormat('m-d', $this->config->winter_start),
                Carbon::createFromFormat('m-d', $this->config->winter_end),
            ];
        }

        return [];
    }

    private function get_reservation_count_query(Ticket $ticket, Carbon $select_date)
    {
        $query = Reservation::query();

        $query->where('ticket_id', $ticket->id);
        $query->where('select_date', $select_date->format('Y-m-d'));
        $query->where('select_time', $select_date->format('H:i:00'));
        $query->whereNull('canceled_at');
        $query->where(function (Builder $q) {
            $q->whereNotNull('paid_at')
                ->orWhere(function (Builder $q) {
                    $q->whereNull('paid_at')
                        ->where('created_at', '>=', Carbon::now()->addMinutes(10));
                });
        });

        return $query;
    }
}
