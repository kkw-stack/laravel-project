<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\Faq;
use Illuminate\Support\Facades\Auth;

class FaqRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'question.required' => __('jt.IN-42'),
            'answer.required' => __('jt.IN-14'),
            'answer.max' => __('jt.IN-40'),
            'faq_category_id.required' => __('jt.IN-29'),
        ];
    }

    public function rules() : array
    {
        return [
            'question' => ['required', 'max:100'],
            'answer' => ['required', 'max:1000'],
            'faq_category_id' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function handle(?Faq $faq)
    {
        $data = $this->validated();

        $data['locale'] = $faq?->locale ?? $this->get_locale();

        if (empty($data['published_at'])) {
            $data['published_at'] = $faq?->published_at ?? now();
        }

        if (is_null($faq)) {
            $this->user('admin')->faqs()->create($data);
        } else {
            $faq->update($data);
        }
    }
}
