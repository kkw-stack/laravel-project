<?php

namespace App\Http\Requests\Front;

use App\Helpers\Formatter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WithdrawRequest extends FormRequest
{
    public function authorize() : bool
    {
        return Auth::guard('web')->check();
    }

    public function rules() : array
    {
        return [
            'password' => ['required', 'regex:' . Formatter::getPasswordRegex(), $this->check_password()],
            'reason' => ['required'],
            'reason_etc' => ['required_if:reason,etc', 'max:500'],
        ];
    }

    public function messages() : array
    {
        return [
            'password.required' => __('jt.IN-02'),
            'password.regex' => __('jt.IN-07'),
            'reason.required' => __('jt.IN-53'),
            'reason_etc.required_if' => __('jt.IN-14'),
            'reason_etc.max' => __('jt.IN-40'),
        ];
    }

    private function check_password()
    {
        return function ($attribute, $value, $fail) {
            if (! Hash::check($value, $this->user()->password)) {
                $fail(__('jt.IN-18'));
            }
        };
    }
}
