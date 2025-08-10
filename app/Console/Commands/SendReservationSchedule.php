<?php

namespace App\Console\Commands;

use App\Jobs\SendReservationScheduleSms;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendReservationSchedule extends Command
{
    protected $signature = 'jt:reservation';
    protected $description = '방문 7일전 알람 발송';

    public function handle()
    {
        $reservations = Reservation::query()
            ->whereNotNull('user_mobile')
            ->whereNotNull('paid_at')
            ->whereNull('used_at')
            ->whereNull('canceled_at')
            ->where('select_date', Carbon::today()->addDays(7))
            ->get();

        foreach ($reservations as $reservation) {
            SendReservationScheduleSms::dispatch($reservation);
        }
    }
}
