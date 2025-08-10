<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LogoutRequest extends FormRequest
{
    public function handle()
    {
        Auth::guard('admin')->logout();

        // $this->session()->invalidate();
        // $this->session()->regenerateToken();
    }
}
