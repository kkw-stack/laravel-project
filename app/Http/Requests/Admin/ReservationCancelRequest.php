<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReservationCancelRequest extends FormRequest
{
    public function authorize() : bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules() : array
    {
        return [
            'cancel_amount' => ['required', 'integer'],
        ];
    }

    public function messages() : array
    {
        return [
            'cancel_amount.required' => __('jt.IN-37'),
            'cancel_amount.integer' => __('jt.IN-37'),
        ];
    }
}
