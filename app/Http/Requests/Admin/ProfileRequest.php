<?php

namespace App\Http\Requests\Admin;

use App\Helpers\Formatter;
use App\Models\Manager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
{
    public function authorize() : bool
    {
        return Auth::guard('admin')->check();
    }

    public function messages() : array
    {
        return [
            'name.required' => __('jt.IN-10'),
            'name.max' => __('jt.IN-36'),
            'phone.required' => __('jt.IN-11'),
            'phone.regex' => __('jt.IN-12'),
            'password.required' => __('jt.IN-02'),
            'password.regex' => __('jt.IN-07'),
        ];
    }

    public function rules() : array
    {
        return [
            'name' => ['required', 'max:8'],
            'phone' => ['required', 'regex:' . Formatter::getPhoneRegex()],
            'password' => ['nullable', 'regex:' . Formatter::getPasswordRegex()],
        ];
    }

    public function handle(Manager $manager)
    {
        $data = $this->validated();

        $manager->update(array_filter($data));
    }
}
