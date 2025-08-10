<?php

namespace App\Http\Requests\Front\Auth;

use App\Helpers\Formatter;
use App\Models\User;
use App\Mail\ChangePasswordMail;
use App\Services\ChangePasswordService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        if (app()->getLocale() === 'en') {
            if ($this->route()->getName() === 'en.auth.change-password.success') {
                return [
                    'password' => ['required', 'confirmed', 'regex:' . Formatter::getPasswordRegex()],
                ];
            }

            return [
                'email' => ['required', 'email', 'exists:users,email'],
            ];
        }

        return [
            'password' => ['required', 'confirmed', 'regex:' . Formatter::getPasswordRegex()],
        ];
    }

    public function messages() : array
    {
        return [
            'email.required' => __('jt.IN-01'),
            'email.email' => __('jt.IN-03'),
            'email.exists' => __('jt.IN-06'),
            'password.required' => __('jt.IN-02'),
            'password.regex' => __('jt.IN-07'),
            'password.confirmed' => __('jt.IN-04'),
        ];
    }

    public function handle()
    {
        $user = $this->session()->get('change_password_user');

        if ($user instanceof User) {
            $user->update($this->validated());
        }
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()->with('nice_data', session('nice_data')),
        );
    }

    public function sendMail()
    {
        $email = $this->email;
        $user = User::where('email', $email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => __('jt.IN-06'),
            ]);
        }

        $token = Password::broker()->createToken($user);

        Mail::to($email)->send(new ChangePasswordMail($token, base64_encode($email)));
    }

    public function changePassword()
    {
        $credentials = [
            'email' => base64_decode($this->email),
            'password' => $this->password,
            'token' => $this->route('token'),
        ];
    
        $status = Password::broker()->reset(
            $credentials,
            function (User $user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();
    
                event(new PasswordReset($user));
            }
        );
    
        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'password' => __('jt.IN-06'),
            ]);
        }
    }

    public function findUserByEmail($email)
    {
        return User::where('locale', 'en')
        ->where('email', $email)
        ->whereNull('deleted_at')
        ->first();
    }
}
