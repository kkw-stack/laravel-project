<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

abstract class AdminFormRequest extends FormRequest
{
    public function authorize() : bool
    {
        return Auth::guard('admin')->check();
    }

    protected function get_locale()
    {
        $locale = $this->query('locale', 'ko');

        return in_array($locale, ['en', 'ko']) ? $locale : 'ko';
    }
}
