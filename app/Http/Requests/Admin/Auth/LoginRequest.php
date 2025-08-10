<?php

namespace App\Http\Requests\Admin\Auth;

use App\Helpers\Formatter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * 로그인 시도 횟수
     */
    private int $blockCount = 5;

    /**
     * 로그인 실패시 제한 시간(초)
     */
    private int $blockSeconds = 300;

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
        $this->ensureIsNotRateLimited();

        if (! Auth::guard('admin')->attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey(), $this->blockSeconds);

            throw ValidationException::withMessages([
                'common' => __('jt.IN-38'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        $this->session()->regenerate();
    }

    private function ensureIsNotRateLimited() : void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), $this->blockCount)) {
            return;
        }

        event(new Lockout($this));

        throw ValidationException::withMessages([
            'common' => __('jt.IN-05'),
        ]);
    }

    private function throttleKey() : string
    {
        return Str::transliterate($this->ip());
    }
}
