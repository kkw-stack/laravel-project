<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class Service
{
    protected function http() : PendingRequest
    {
        return Http::withoutVerifying();
    }
}
