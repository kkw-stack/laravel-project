<?php

namespace App\Console\Commands;

use App\Jobs\SendReservationDayBeforeSms;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendReservationDayBefore extends Command
{
    protected $signature = 'jt:reservation-daybefore';
    protected $description = '방문 1일전 알람 발송';

    public function handle()
    {
        $reservations = Reservation::query()
            ->whereNotNull('user_mobile')
            ->whereNotNull('paid_at')
            ->whereNull('used_at')
            ->whereNull('canceled_at')
            ->where('select_date', Carbon::today()->addDay())
            ->get();

        foreach ($reservations as $reservation) {
            SendReservationDayBeforeSms::dispatch($reservation);
        }
    }
}
