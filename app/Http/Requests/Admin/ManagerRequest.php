<?php

namespace App\Http\Requests\Admin;

use App\Helpers\Formatter;
use App\Models\Manager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ManagerRequest extends FormRequest
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
            'email.required' => __('jt.IN-01'),
            'email.email' => __('jt.IN-03'),
            'email.unique' => __('jt.IN-35'),
            'phone.required' => __('jt.IN-11'),
            'phone.regex' => __('jt.IN-12'),
            'password.required' => __('jt.IN-02'),
            'password.regex' => __('jt.IN-07'),
        ];
    }

    public function rules() : array
    {
        $rules = [
            'name' => ['required', 'max:8'],
            'phone' => ['required', 'regex:' . Formatter::getPhoneRegex()],
            'password' => ['regex:' . Formatter::getPasswordRegex()],
        ];

        if ($this->route('manager') instanceof Manager) {
            $rules['password'] = array_merge(['nullable'], $rules['password']);
        } else {
            $rules['password'] = array_merge(['required'], $rules['password']);
            $rules['email'] = ['required', 'email', Rule::unique('managers', 'email')->ignore($this->route('manager')?->id)];
        }

        return $rules;
    }

    public function handle(?Manager $manager)
    {
        $data = $this->validated();

        $data['phone'] = Formatter::phone($data['phone']);

        if (is_null($manager)) {
            Manager::create($data);
        } else {
            $manager->update(array_filter($data));
        }
    }
}
