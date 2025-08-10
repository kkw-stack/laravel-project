<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\History;

class HistoryRequest extends AdminFormRequest
{
    public function rules() : array
    {
        $isUpdate = $this->route('history') instanceof History;

        return [
            'year' => ['required', 'string', 'max:4'],
            'content' => ['required', 'array'],
            'content.*.content' => ['required', 'string', 'max:200'],
            'content.*.use_image' => ['boolean'],
            'content.*.size' => ['required_with:content.*.use_image'],
            'content.*.image' => [$isUpdate ? 'nullable' : 'required_with:content.*.use_image', 'image', 'max:2048'],
            'category_id' => ['required', 'exists:history_categories,id'],
            'status' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function messages() : array
    {
        return [
            'year.required' => __('jt.IN-34'),
            'year.max' => __('jt.IN-40'),
            'content.*.content.required' => __('jt.IN-14'),
            'content.*.content.max' => __('jt.IN-40'),
            'content.*.size.required_with' => __('jt.IN-37'),
            'content.*.image.required_with' => __('jt.IN-23'),
            'content.*.image.image' => __('jt.IN-16'),
            'content.*.image.max' => __('jt.IN-17'),
            'category_id.required' => __('jt.IN-29'),
            'category_id.exists' => __('jt.IN-43'),
        ];
    }

    public function handle(?History $history)
    {
        $data = $this->validated();

        $data['locale'] = $history?->locale ?? $this->get_locale();

        if (empty($data['published_at'])) {
            $data['published_at'] = $history?->published_at ?? now();
        }

        foreach ($data['content'] as $idx => $content) {
            $data['content'][$idx]['image'] = $this->hasFile("content.{$idx}.image") ? $this->file("content.{$idx}.image")->store('history', 'public') : $this->input("content.{$idx}.image_path");
        }

        if (is_null($history)) {
            $history = $this->user('admin')->histories()->create($data);
        } else {
            $history->update($data);
        }
    }
}
