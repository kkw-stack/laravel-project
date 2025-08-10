<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\Popup;

class PopupRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-13'),
            'title.max' => __('jt.IN-40'),
            'image.required' => __('jt.IN-23'),
            'image.image' => __('jt.IN-24'),
            'image.max' => __('jt.IN-17'),
            'start_date.required_without' => __('jt.IN-19'),
            'start_date.before_or_equal' => __('jt.IN-20'),
            'start_date.date' => __('jt.IN-39'),
            'end_date.required_without' => __('jt.IN-21'),
            'end_date.after_or_equal' => __('jt.IN-22'),
            'end_date.date' => __('jt.IN-39'),
            'url.url' => __('jt.IN-41'),
            'status.required' => __('jt.IN-37'),
            'status.boolean' => __('jt.IN-37'),
        ];
    }

    public function rules() : array
    {
        $isUpdate = $this->route('popup') instanceof Popup;

        return [
            'title' => ['required', 'max:40'],
            'image' => [$isUpdate ? 'nullable' : 'required', 'image', 'max:2048'],
            'start_date' => ['nullable', 'required_without:use_always', 'date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'required_without:use_always', 'date', 'after_or_equal:start_date'],
            'url' => ['nullable', 'url'],
            'top' => ['nullable', 'integer'],
            'left' => ['nullable', 'integer'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function handle(?Popup $popup)
    {
        $data = $this->validated();

        $data['locale'] = $popup?->locale ?? $this->get_locale();
        $data['use_always'] = $this->has('use_always');
        $data['target'] = $this->has('target');

        if ($this->hasFile('image')) {
            $data['image'] = $this->file('image')->store('popup', 'public');
        }

        if (empty($data['start_date'])) {
            $data['start_date'] = null;
        }

        if (empty($data['end_date'])) {
            $data['end_date'] = null;
        }

        if ($data['top'] === '') {
            $data['top'] = null;
        }

        if ($data['left'] === '') {
            $data['left'] = null;
        }

        if (is_null($popup)) {
            $this->user('admin')->popups()->create($data);
        } else {
            $popup->update($data);
        }
    }
}
