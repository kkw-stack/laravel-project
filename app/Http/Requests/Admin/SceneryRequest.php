<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\SceneryGallery;

class SceneryRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-13'),
            'title.max' => __('jt.IN-40'),
            'thumbnail.required' => __('jt.IN-23'),
            'thumbnail.file' => __('jt.IN-24'),
            'thumbnail.image' => __('jt.IN-16'),
            'thumbnail.max' => __('jt.IN-17', ['size' => '2MB']),
            'scenery_category_id.required' => __('jt.IN-29'),
            'status.required' => __('jt.IN-37'),
            'status.boolean' => __('jt.IN-37'),
            'published_at.date' => __('jt.IN-39'),
        ];
    }

    public function rules() : array
    {
        return [
            'title' => ['required', 'max:200'],
            'thumbnail' => [($this->route('scenery') ? 'nullable' : 'required'), 'file', 'image', 'max:2048'],
            'scenery_category_id' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function handle(?SceneryGallery $scenery)
    {
        $data = $this->validated();

        $data['locale'] = $scenery?->locale ?? $this->get_locale();

        if (empty($data['published_at'])) {
            $data['published_at'] = $scenery?->published_at ?? now();
        }

        if (is_null($scenery)) {
            $scenery = $this->user('admin')->sceneries()->create($data);
        } else {
            $scenery->update($data);
        }

        if ($this->hasFile('thumbnail')) {
            $scenery->update([
                'thumbnail' => $this->file('thumbnail')->storeAs('board/scenery/' . $scenery->id, 'thumbnail.' . $this->file('thumbnail')->extension(), 'public'),
            ]);
        }
    }
}
