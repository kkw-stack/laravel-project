<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Services\AligoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReservationScheduleSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Reservation $reservation,
    ) {
    }

    public function handle(AligoService $aligo) : void
    {
        $aligo->send_schedule($this->reservation);
    }
}
