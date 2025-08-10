<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\News;

class NewsRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'link.required_with' => __('jt.IN-15'),
            'link.url' => __('jt.IN-41'),
            'title.required' => __('jt.IN-13'),
            'title.max' => __('jt.IN-40'),
            'content.required_without' => __('jt.IN-14'),
            'status.required' => __('jt.IN-37'),
            'status.boolean' => __('jt.IN-37'),
            'published_at.date' => __('jt.IN-39'),
        ];
    }

    public function rules() : array
    {
        return [
            'link' => ['nullable', 'required_with:use_link', 'url'],
            'title' => ['required', 'max:200'],
            'content' => ['required_without:use_link'],
            'status' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function handle(?News $news)
    {
        $data = $this->validated();

        $data['locale'] = $news?->locale ?? $this->get_locale();
        $data['use_link'] = $this->has('use_link');

        if (empty($data['published_at'])) {
            $data['published_at'] = $news?->published_at ?? now();
        }

        $data['content'] = $data['content'] ?? '';

        if (is_null($news)) {
            $this->user('admin')->news()->create($data);
        } else {
            $news->update($data);
        }
    }
}
