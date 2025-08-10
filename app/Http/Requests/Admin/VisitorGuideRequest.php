<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\VisitorGuide;

class VisitorGuideRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-13'),
            'title.max' => __('jt.IN-40'),
            'content.*.title.required' => __('jt.IN-48'),
            'content.*.title.max' => __('jt.IN-40'),
            'content.*.array.required_without' => __('jt.IN-14'),
            'content.*.array.*.required_without' => __('jt.IN-14'),
            'content.*.array.*.max' => __('jt.IN-40'),
            'content.*.table.required_with' => __('jt.IN-14'),
            'status.required' => __('jt.IN-37'),
            'status.boolean' => __('jt.IN-37'),
            'published_at.date' => __('jt.IN-39'),
        ];
    }

    public function rules() : array
    {
        return [
            'title' => ['required', 'max:50'],
            'content' => ['array', 'min:1'],
            'content.*.title' => ['required', 'max:100'],
            'content.*.array' => ['required_without:content.*.use_table', 'array'],
            'content.*.array.*' => ['required_without:content.*.use_table', 'max:1000'],
            'content.*.table' => ['required_with:content.*.use_table'],
            'status' => [
                'required',
                'boolean',
                function ($attribute, $value, $fail) {
                    if ($this->route('guide') instanceof VisitorGuide && false == $value) {
                        if (false === VisitorGuide::where('id', '!=', $this->route('guide')->id)->where('revision_id', 0)->where('status', true)->exists()) {
                            $fail(__('jt.IN-50'));
                        }
                    }
                }
            ],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function handle(?VisitorGuide $guide)
    {
        $data = $this->validated();

        $data['locale'] = $guide?->locale ?? $this->get_locale();

        if (empty($data['published_at'])) {
            $data['published_at'] = $guide?->published_at ?? now();
        }

        foreach ($data['content'] as $idx => $content) {
            $data['content'][$idx]['use_table'] = $this->has("content.{$idx}.use_table");
        }

        if (is_null($guide)) {
            $this->user('admin')->visitorGuides()->create($data);
        } else {
            $replica = $guide->replicate();
            $replica->revision_id = $guide->id;
            $replica->updated_at = now();
            $replica->save();

            $guide->update($data);
        }
    }
}
