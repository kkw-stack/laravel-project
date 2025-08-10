<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\KoreaGarden;

class KoreaGardenRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-48'),
            'title.max' => __('jt.IN-40'),
            'content.required' => __('jt.IN-14'),
            'content.max' => __('jt.IN-40'),
            'image.required' => __('jt.IN-23'),
            'image.image' => __('jt.IN-24'),
            'image.max' => __('jt.IN-17'),
            'image_mobile.required' => __('jt.IN-23'),
            'image_mobile.image' => __('jt.IN-24'),
            'image_mobile.max' => __('jt.IN-17'),
            'video.url' => __('jt.IN-41'),
            'video_mobile.url' => __('jt.IN-41'),
            'category_id.required' => __('jt.IN-29'),
            'category_id.exists' => __('jt.IN-43'),
            'status.required' => __('jt.IN-37'),
            'status.boolean' => __('jt.IN-37'),
            'published_at.date' => __('jt.IN-39'),
        ];
    }

    public function rules() : array
    {
        $isUpdate = $this->route('garden') instanceof KoreaGarden;

        return [
            'title' => ['required', 'max:70'],
            'content' => ['required', 'max:300'],
            'image' => [$isUpdate ? 'nullable' : 'required', 'image', 'max:2048'],
            'image_mobile' => ['nullable', 'image', 'max:2048'],
            'video' => ['nullable', 'url'],
            'video_mobile' => ['nullable', 'url'],
            'category_id' => ['required', 'exists:korea_garden_categories,id'],
            'status' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function handle(?KoreaGarden $garden)
    {
        $data = $this->validated();

        $data['locale'] = $garden?->locale ?? $this->get_locale();

        if ($this->hasFile('image')) {
            $data['image'] = $this->file('image')->store('garden/hanguk', 'public');
        }

        if ($this->hasFile('image_mobile')) {
            $data['image_mobile'] = $this->file('image_mobile')->store('garden/hanguk', 'public');
        }

        if (empty($data['published_at'])) {
            $data['published_at'] = $garden?->published_at ?? now();
        }

        if (is_null($garden)) {
            $garden = $this->user('admin')->koreaGardens()->create($data);
        } else {
            $garden->update($data);
        }
    }
}
