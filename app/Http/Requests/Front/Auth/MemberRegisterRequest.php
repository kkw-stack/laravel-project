<?php

namespace App\Http\Requests\Front\Auth;

use App\Helpers\Formatter;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MemberRegisterRequest extends FormRequest
{
    public function authorize() : bool
    {
        return ! Auth::check();
    }

    public function rules() : array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', $this->validateEmailReactivationPeriod(), 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'regex:' . Formatter::getPasswordRegex()],
            'location' => ['required', 'string'],
            'source' => ['nullable', 'string'],
            'source_etc' => ['required_if:source,기타', 'max:100'],
        ];
    }

    public function messages() : array
    {
        return [
            'email.required' => __('jt.IN-01'),
            'email.string' => __('jt.IN-03'),
            'email.lowercase' => __('jt.IN-03'),
            'email.email' => __('jt.IN-03'),
            'email.max' => __('jt.IN-03'),
            'email.unique' => __('jt.IN-35'),
            'password.required' => __('jt.IN-02'),
            'password.regex' => __('jt.IN-07'),
            'password.confirmed' => __('jt.IN-04'),
            'location.required' => __('jt.IN-52'),
            'source_etc.required_if' => __('jt.IN-14'),
            'source_etc.max' => __('jt.IN-40'),
        ];
    }

    public function handle()
    {
        $strNow = date('Y-m-d H:i:s');

        $nice_data = $this->session()->pull('nice_data');
        $user_data = $this->validated();
        
        if ($nice_data) {
            $user_data = array_merge($user_data, $nice_data);
        }

        if(app()->getLocale() === 'en') {
            $user_data['name'] = '';
            $user_data['locale'] = 'en';
        }
    
        $user_data['marketing'] = $this->exists('marketing');
        $user_data['marketing_updated_at'] = $strNow;

        if ($this->session()->exists('kakao_id')) {
            $user_data['kakao_id'] = $this->session()->pull('kakao_id');
            $user_data['kakao_connected'] = $strNow;
        }

        if ($this->session()->exists('naver_id')) {
            $user_data['naver_id'] = $this->session()->pull('naver_id');
            $user_data['naver_connected'] = $strNow;
        }

        if ($this->session()->exists('google_id')) {
            $user_data['google_id'] = $this->session()->pull('google_id');
            $user_data['google_connected'] = $strNow;
        }

        return User::create($user_data);
    }
    
    private function validateEmailReactivationPeriod()
    {
        return function ($attribute, $value, $fail) {
            if (app()->getLocale() === 'en') {
                $user = User::withTrashed()->where('email', $value)->first();
    
                if ($user && $user->trashed()) {
                    $daysSinceDeleted = $user->deleted_at->diffInDays(now());
    
                    if ($daysSinceDeleted < 30) {
                        throw ValidationException::withMessages([
                            'email' => __('When your account is deleted, re-registration with the same ID is not possible for 30 days.'),
                        ]);
                    }
                }
            }
        };
    }
    
}
