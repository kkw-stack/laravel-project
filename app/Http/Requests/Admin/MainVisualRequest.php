<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\MainVisual;

class MainVisualRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-13'),
            'title.max' => __('jt.IN-40'),
            'thumbnail.required' => __('jt.IN-23'),
            'thumbnail.image' => __('jt.IN-24'),
            'thumbnail.max' => __('jt.IN-17'),
            'thumbnail_mobile.image' => __('jt.IN-24'),
            'thumbnail_mobile.max' => __('jt.IN-17'),
            'weather_icon.required' => __('jt.IN-37'),
            'description.required' => __('jt.IN-25'),
            'description.max' => __('jt.IN-40'),
            'status.required' => __('jt.IN-37'),
            'status.boolean' => __('jt.IN-37'),
        ];
    }

    public function rules() : array
    {
        $isUpdate = $this->route('visual') instanceof MainVisual;

        return [
            'title' => ['required', 'max:70'],
            'thumbnail' => [$isUpdate ? 'nullable' : 'required', 'image', 'max:2048'],
            'thumbnail_mobile' => ['nullable', 'image', 'max:2048'],
            'video' => ['nullable', 'url'],
            'video_mobile' => ['nullable', 'url'],
            'weather_icon' => ['required'],
            'description' => ['nullable', 'max:100'],
            'status' => [
                'required',
                'boolean',
                function ($attribute, $value, $fail) {
                    if ($this->route('visual') instanceof MainVisual && false == $value) {
                        if (false === MainVisual::where('id', '!=', $this->route('visual')->id)->where('status', true)->exists()) {
                            $fail(__('jt.IN-50'));
                        }
                    }
                }
            ],
        ];
    }

    public function handle(?MainVisual $visual)
    {
        $data = $this->validated();

        $data['locale'] = $visual?->locale ?? $this->get_locale();

        if ($this->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->file('thumbnail')->store('main/visual', 'public');
        }

        if ($this->hasFile('thumbnail_mobile')) {
            $data['thumbnail_mobile'] = $this->file('thumbnail_mobile')->store('main/visual', 'public');
        }

        if (is_null($visual)) {
            $data['order_idx'] = 0;

            $visual = $this->user('admin')->mainVisuals()->create($data);
        } else {
            if (! $data['status']) {
                $data['order_idx'] = 0;
            }

            $visual->update($data);
        }
    }
}
