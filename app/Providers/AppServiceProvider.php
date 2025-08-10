<?php

namespace App\Providers;

use App\Jobs\SendReservationCancelSms;
use App\Jobs\SendReservationScheduleSms;
use App\Jobs\SendReservationSuccessSms;
use App\Jobs\SendReservationDayBeforeSms;
use App\Services\AligoService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() : void
    {
        $this->app->bindMethod([SendReservationSuccessSms::class, 'handle'], function (SendReservationSuccessSms $job, Application $app) {
            return $job->handle($app->make(AligoService::class));
        });
        $this->app->bindMethod([SendReservationCancelSms::class, 'handle'], function (SendReservationCancelSms $job, Application $app) {
            return $job->handle($app->make(AligoService::class));
        });
        $this->app->bindMethod([SendReservationScheduleSms::class, 'handle'], function (SendReservationScheduleSms $job, Application $app) {
            return $job->handle($app->make(AligoService::class));
        });
        $this->app->bindMethod([SendReservationDayBeforeSms::class, 'handle'], function (SendReservationDayBeforeSms $job, Application $app) {
            return $job->handle($app->make(AligoService::class));
        });
    }
}
