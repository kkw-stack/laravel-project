<?php

namespace App\Http\Requests\Front;

use App\Helpers\Formatter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileRequest extends FormRequest
{
    public function authorize() : bool
    {
        return Auth::guard('web')->check();
    }

    public function rules() : array
    {
        return [
            // 'current-password' => ['required_with:password', 'nullable', 'regex:' . Formatter::getPasswordRegex(), $this->check_password()],
            // 'password' => ['nullable', 'confirmed', 'regex:' . Formatter::getPasswordRegex()],
            'location' => ['required', 'string'],
        ];
    }

    public function messages() : array
    {
        return [
            // 'current-password.required_with' => __('jt.IN-02'),
            // 'current-password.regex' => __('jt.IN-07'),
            // 'password.regex' => __('jt.IN-07'),
            // 'password.confirmed' => __('jt.IN-04'),
            'location.required' => __('jt.IN-52'),
        ];
    }

    public function handle()
    {
        $data = [
            'location' => $this->input('location'),
        ];

        $data['marketing'] = $this->exists('marketing');
        $data['marketing_updated_at'] = Carbon::now();

        // if (! empty($this->input('password'))) {
        //     $data['password'] = $this->input('password');
        // }

        $this->user('web')->update($data);
    }

    private function check_password()
    {
        return function ($attribute, $value, $fail) {
            if (! empty($value) && ! Hash::check($value, $this->user('web')->password)) {
                $fail(__('jt.IN-18'));
            }
        };
    }
}
