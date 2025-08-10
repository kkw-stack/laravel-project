<?php

namespace App\Http\Requests\Front\Auth;

use App\Models\User;
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

    public function authorize() : bool
    {
        return true;
    }

    public function messages() : array
    {
        return [
            'email.required' => __('jt.IN-01'),
            'email.email' => __('jt.IN-03'),
            'password.required' => __('jt.IN-02'),
        ];
    }

    public function rules() : array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function handle() : void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey(), $this->blockSeconds);

            throw ValidationException::withMessages([
                'password' => __('jt.IN-38'),
            ]);
        }

        $user = User::where('email', $this->input('email'))->first();

        if ($user->locale !== app()->getLocale()) {
            throw ValidationException::withMessages([
                'password' => __('jt.IN-38'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        $this->session()->regenerate();
        $this->user()?->update([
            'last_logged_in' => date('Y-m-d H:i:s'),
        ]);

        if ($this->session()->has('nice_data')) {
            $this->session()->remove('nice_data');
        }
    }

    private function ensureIsNotRateLimited() : void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), $this->blockCount)) {
            return;
        }

        event(new Lockout($this));

        throw ValidationException::withMessages([
            'password' => __('jt.IN-05'),
        ]);
    }

    private function throttleKey() : string
    {
        return Str::transliterate($this->ip());
    }
}
