<?php

namespace App\Http\Requests\Admin;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;

class TicketRequest extends FormRequest
{
    public function authorize() : bool
    {
        return Auth::guard('admin')->check();
    }

    public function messages() : array
    {
        $messages = [
            'title.ko.required' => __('jt.IN-10'),
            'title.ko.max' => __('jt.IN-40'),
            'title.en.required' => __('jt.IN-10'),
            'title.en.max' => __('jt.IN-40'),
            'sector.ko.required' => __('jt.IN-14'),
            'sector.ko.max' => __('jt.IN-40'),
            'sector.en.required' => __('jt.IN-14'),
            'sector.en.max' => __('jt.IN-40'),
            'time_table.*.time.required' => __('jt.IN-37'),
            'time_table.*.time.distinct' => __('jt.IN-58'),
            'time_table.*.time.date_format' => __('jt.IN-37'),
            'time_table.*.total.required' => __('jt.IN-47'),
            'time_table.*.total.integer' => __('jt.IN-47'),
            'time_table.*.total.min' => __('jt.IN-47'),
            'time_table.*.total.max' => __('jt.IN-47'),
            'night_start_date.required_with' => __('jt.IN-19'),
            'night_start_date.date_format' => __('jt.IN-39'),
            'night_start_date.before_or_equal' => __('jt.IN-20'),
            'night_end_date.required_with' => __('jt.IN-21'),
            'night_end_date.date_format' => __('jt.IN-39'),
            'night_end_date.after_or_equal' => __('jt.IN-22'),
            'night_time_table.*.time.required_with' => __('jt.IN-37'),
            'night_time_table.*.time.distinct' => __('jt.IN-58'),
            'night_time_table.*.time.date_format' => __('jt.IN-37'),
            'night_time_table.*.total.required_with' => __('jt.IN-47'),
            'night_time_table.*.total.integer' => __('jt.IN-47'),
            'night_time_table.*.total.min' => __('jt.IN-47'),
            'night_time_table.*.total.max' => __('jt.IN-47'),
            'disable_time_table.*.date.required' => __('jt.IN-60'),
            'disable_time_table.*.date.date' => __('jt.IN-60'),
            'disable_time_table.*.time.required' => __('jt.IN-37'),
            'disable_time_table.*.time.date_format' => __('jt.IN-37'),
            'status.required' => __('jt.IN-37'),
        ];

        foreach (array_merge(array_keys(Ticket::PRICE_FOREIGN_LABELS), array_keys(Ticket::PRICE_LABELS)) as $key) {
            $messages["price.{$key}.peak.required"] = __('jt.IN-57');
            $messages["price.{$key}.off.required"] = __('jt.IN-57');

            $messages["price.{$key}.peak.integer"] = __('jt.IN-57');
            $messages["price.{$key}.off.integer"] = __('jt.IN-57');

            $messages["price.{$key}.peak.min"] = __('jt.IN-59');
            $messages["price.{$key}.off.min"] = __('jt.IN-59');

            $messages["price.{$key}.peak.max"] = __('jt.IN-59');
            $messages["price.{$key}.off.max"] = __('jt.IN-59');
        }

        return $messages;
    }

    public function rules() : array
    {
        $timeTableTimeRule = ['distinct', 'date_format:i:s'];
        $timeTableTotalRule = ['integer', 'min:1', 'max:999'];
        $timeTableDocentRule = ['boolean'];
        $priceRule = ['required', 'integer', 'min:0', 'max:999999'];

        $rules = [
            'title.ko' => ['required', 'string', 'max:20'],
            'title.en' => ['required', 'string', 'max:60'],
            'sector.ko' => ['required', 'string', 'max:20'],
            'sector.en' => ['required', 'string', 'max:80'],
            'time_table' => ['required', 'array', 'min:1', 'max:144'],
            'time_table.*.time' => ['required', ...$timeTableTimeRule],
            'time_table.*.total' => ['required', ...$timeTableTotalRule],
            'time_table.*.docent' => $timeTableDocentRule,
            'use_night_time_table' => ['boolean'],
            'night_start_date' => ['nullable', 'required_with:use_night_time_table', 'date_format:m-d', 'before_or_equal:night_end_date'],
            'night_end_date' => ['nullable', 'required_with:use_night_time_table', 'date_format:m-d', 'after_or_equal:night_start_date'],
            'night_time_table' => ['array'],
            'night_time_table.*.time' => ['nullable', 'required_with:use_night_time_table', ...$timeTableTimeRule],
            'night_time_table.*.total' => ['nullable', 'required_with:use_night_time_table', ...$timeTableTotalRule],
            'night_time_table.*.docent' => $timeTableDocentRule,
            'disable_time_table' => ['array'],
            'disable_time_table.*.date' => ['required', 'date'],
            'disable_time_table.*.time' => ['required', 'date_format:i:s'],
            'status' => ['required', 'boolean'],
        ];

        foreach (array_keys(Ticket::PRICE_LABELS) as $key) {
            $rules["price.{$key}.peak"] = $priceRule;
            $rules["price.{$key}.off"] = $priceRule;
        }

        foreach (array_keys(Ticket::PRICE_FOREIGN_LABELS) as $key) {
            $rules["price.{$key}.peak"] = $priceRule;
            $rules["price.{$key}.off"] = $priceRule;
        }

        return $rules;
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $timeTable = $this->input('time_table.*.time', []);
            $nightTimeTable = $this->input('night_time_table.*.time', []);

            $intersection = array_intersect($timeTable, $nightTimeTable);

            if (! empty($intersection)) {
                foreach ($timeTable as $idx => $time) {
                    if (in_array($time, $intersection)) {
                        $validator->errors()->add("time_table.{$idx}.time", __('jt.IN-58'));
                    }
                }
                foreach ($nightTimeTable as $idx => $time) {
                    if (in_array($time, $intersection)) {
                        $validator->errors()->add("night_time_table.{$idx}.time", __('jt.IN-58'));
                    }
                }
            }
        });
    }

    public function handle(?Ticket $ticket) : void
    {
        $data = $this->validated();

        $data['use_night_time_table'] = $this->has('use_night_time_table');

        if (empty($data['night_start_date'])) {
            $data['night_start_date'] = null;
        }

        if (empty($data['night_end_date'])) {
            $data['night_end_date'] = null;
        }

        if (empty($data['night_time_table'])) {
            $data['night_time_table'] = [];
        }

        if (empty($data['disable_time_table'])) {
            $data['disable_time_table'] = [];
        }

        if (is_null($ticket)) {
            $this->user('admin')->tickets()->create($data);
        } else {
            $ticket->update($data);
        }
    }
}
