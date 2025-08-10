<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages() : array
    {
        return [
            'email.required' => __('jt.IN-01'),
            'email.email' => __('jt.IN-03'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function handle()
    {
        $status = Password::broker('admins')->sendResetLink($this->only('email'));

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'common' => __('jt.IN-06'),
            ]);
        }
    }
}
