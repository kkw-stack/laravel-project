<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\Attraction;

class AttractionRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-44'),
            'title.max' => __('jt.IN-40'),
            'content.required' => __('jt.IN-14'),
            'content.max' => __('jt.IN-40'),
            'source.required' => __('jt.IN-45'),
            'source.max' => __('jt.IN-40'),
            'distance.required' => __('jt.IN-46'),
            'distance.integer' => __('jt.IN-47'),
            'distance.min' => __('jt.IN-47'),
            'distance.max_digits' => __('jt.IN-40'),
            'thumbnail.required' => __('jt.IN-23'),
            'thumbnail.image' => __('jt.IN-24'),
            'thumbnail.max' => __('jt.IN-17'),
            'status.required' => __('jt.IN-37'),
            'status.boolean' => __('jt.IN-37'),
            'published_at.date' => __('jt.IN-39'),
        ];
    }

    public function rules() : array
    {
        $isUpdate = $this->route('attraction') instanceof Attraction;

        $thumbnailRequired = $isUpdate ? 'nullable' : 'required';
        return [
            'title' => ['required', 'max:50'],
            'content' => ['required', 'max:1000'],
            'source' => ['nullable', 'max:50'],
            'distance' => ['required', 'integer', 'min:0', 'max_digits:5'],
            'thumbnail' => [$thumbnailRequired, 'image', 'max:2048'],
            'status' => [
                'required',
                'boolean',
                function ($attribute, $value, $fail) {
                    if ($this->route('attraction') instanceof Attraction && false == $value) {
                        if (false === Attraction::where('id', '!=', $this->route('attraction')->id)->where('status', true)->exists()) {
                            $fail(__('jt.IN-50'));
                        }
                    }
                }
            ],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function handle(?Attraction $attraction)
    {
        $data = $this->validated();

        $data['locale'] = $attraction?->locale ?? $this->get_locale();

        if (empty($data['published_at'])) {
            $data['published_at'] = $attraction?->published_at ?? now();
        }

        if ($this->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->file('thumbnail')->store('attraction', 'public');
        }

        if (is_null($attraction)) {
            $attraction = $this->user('admin')->attractions()->create($data);
        } else {
            $attraction->update($data);
        }
    }
}
