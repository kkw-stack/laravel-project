<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\Privacy;

class PrivacyRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-13'),
            'title.max' => __('jt.IN-40'),
            'content.required' => __('jt.IN-14'),
            'status.required' => __('jt.IN-37'),
            'status.boolean' => __('jt.IN-37'),
            'published_at.date' => __('jt.IN-39'),
        ];
    }

    public function rules() : array
    {
        return [
            'title' => ['required', 'max:20'],
            'content' => ['required'],
            'status' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function handle(?Privacy $privacy)
    {
        $data = $this->validated();

        $data['locale'] = $privacy?->locale ?? $this->get_locale();
        $data['is_notice'] = $this->has('is_notice');

        if (empty($data['published_at'])) {
            $data['published_at'] = $privacy?->published_at ?? now();
        }

        if (is_null($privacy)) {
            $privacy = $this->user('admin')->privacies()->create($data);
        } else {
            $privacy->update($data);
        }
    }
}
