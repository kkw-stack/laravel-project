<?php

use App\Console\Commands\SendReservationSchedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::command('jt:publish')->everyMinute();

Schedule::command('sitemap:generate')->daily();
Schedule::command('jt:reservation')->dailyAt('09:00');
Schedule::command('jt:reservation-daybefore')->dailyAt('09:00');
//Schedule::command('auth:clear-resets')->everyFifteenMinutes();

Schedule::command('jt:weather:update')->hourly();
