<?php

namespace App\Http\Requests\Admin;

use App\Models\TicketConfig;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TicketConfigRequest extends FormRequest
{
    public function authorize() : bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules() : array
    {
        return [
            'max_date' => ['nullable', 'integer', 'min:1', 'max:365'],
            'max_count' => ['nullable', 'integer', 'min:1', 'max:99'],
            'max_docent' => ['nullable', 'integer', 'min:1', 'max:99'],
            'summer_start' => [
                'nullable',
                'required_with:summer_end',
                'date_format:m-d',
                'before_or_equal:summer_end',
            ],
            'summer_end' => [
                'nullable',
                'required_with:summer_start',
                'date_format:m-d',
                'after_or_equal:summer_start',
            ],
            'winter_start' => [
                'nullable',
                'required_with:winter_end',
                'nullable',
                'date_format:m-d',
                // 'before_or_equal:winter_end',
            ],
            'winter_end' => [
                'nullable',
                'required_with:winter_start',
                'nullable',
                'date_format:m-d',
                // 'after_or_equal:winter_start',
            ],
            'closed_weekday' => ['nullable', 'array', 'max:7'],
            'closed_weekday.*' => ['distinct', 'integer', 'min:0', 'max:6'],
            'closed_dates' => ['nullable', 'array'],
            'closed_dates.*.start' => ['required', 'date', 'before_or_equal:closed_dates.*.end'],
            'closed_dates.*.end' => ['required', 'date', 'after_or_equal:closed_dates.*.start'],
        ];
    }

    public function messages() : array
    {
        return [
            'max_date.integer' => __('jt.IN-61'),
            'max_date.min' => __('jt.IN-61'),
            'max_date.max' => __('jt.IN-61'),
            'max_count.integer' => __('jt.IN-61'),
            'max_count.min' => __('jt.IN-61'),
            'max_count.max' => __('jt.IN-61'),
            'max_docent.integer' => __('jt.IN-61'),
            'max_docent.min' => __('jt.IN-61'),
            'max_docent.max' => __('jt.IN-61'),
            'summer_start.required_with' => __('jt.IN-19'),
            'summer_start.date_format' => __('jt.IN-39'),
            'summer_start.before_or_equal' => __('jt.IN-20'),
            'summer_end.required_with' => __('jt.IN-21'),
            'summer_end.date_format' => __('jt.IN-39'),
            'summer_end.after_or_equal' => __('jt.IN-22'),
            'winter_start.required_with' => __('jt.IN-19'),
            'winter_start.date_format' => __('jt.IN-39'),
            'winter_start.before_or_equal' => __('jt.IN-20'),
            'winter_end.required_with' => __('jt.IN-21'),
            'winter_end.date_format' => __('jt.IN-39'),
            'winter_end.after_or_equal' => __('jt.IN-22'),
            'closed_dates.*.start.required' => __('jt.IN-19'),
            'closed_dates.*.start.date' => __('jt.IN-39'),
            'closed_dates.*.start.before_or_equal' => __('jt.IN-20'),
            'closed_dates.*.end.required' => __('jt.IN-22'),
            'closed_dates.*.end.date' => __('jt.IN-39'),
            'closed_dates.*.end.after_or_equal' => __('jt.IN-22'),
        ];
    }

    public function handle()
    {
        TicketConfig::create(array_filter($this->validated()));
    }
}
