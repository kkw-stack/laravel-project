<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\Notice;

class NoticeRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-13'),
            'title.max' => __('jt.IN-40'),
            'content.required' => __('jt.IN-14'),
            'files.mimes' => __('jt.IN-16'),
            'files.max' => __('jt.IN-17', ['size' => '10MB']),
            'status.required' => __('jt.IN-37'),
            'status.boolean' => __('jt.IN-37'),
            'published_at.date' => __('jt.IN-39'),
        ];
    }

    public function rules() : array
    {
        return [
            'title' => ['required', 'max:200'],
            'content' => ['required'],
            'files.*' => ['nullable', 'file', 'max:10240', 'mimes:zip,ppt,pptx,pdf,jpg,jpeg,png,webp,xlsx'],
            'status' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function handle(?Notice $notice)
    {
        $data = $this->validated();

        $data['locale'] = $notice?->locale ?? $this->get_locale();
        $data['is_notice'] = $this->has('is_notice');

        if (empty($data['published_at'])) {
            $data['published_at'] = $notice?->published_at ?? now();
        }

        if (is_null($notice)) {
            $notice = $this->user('admin')->notices()->create($data);
        } else {
            $notice->update($data);

            if ($this->has('delete_files')) {
                foreach ($this->delete_files as $file_id) {
                    $notice->files()->find($file_id)->delete();
                }
            }
        }

        if ($this->hasFile('files')) {
            foreach ($this->file('files') as $file) {
                $notice->files()->create([
                    'file_mime' => $file->getMimeType(),
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'file_path' => $file->store('board/notice/' . $notice->id, 'public'),
                ]);
            }
        }
    }
}
