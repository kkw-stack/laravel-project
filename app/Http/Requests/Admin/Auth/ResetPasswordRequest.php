<?php

namespace App\Http\Requests\Admin\Auth;

use App\Helpers\Formatter;
use App\Models\Manager;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordRequest extends FormRequest
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
            'password.required' => __('jt.IN-02'),
            'password.regex' => __('jt.IN-07'),
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
            'password' => ['required', 'regex:' . Formatter::getPasswordRegex()],
        ];
    }

    public function handle()
    {
        $status = Password::broker('admins')->reset(
            array_merge($this->only('email', 'password'), ['token' => $this->route('token')]),
            function (Manager $user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'common' => __('jt.IN-06'),
            ]);
        }
    }
}
