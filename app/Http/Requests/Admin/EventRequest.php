<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\Event;

class EventRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-13'),
            'title.max' => __('jt.IN-40'),
            'content.required' => __('jt.IN-14'),
            'location.max' => __('jt.IN-40'),
            'files.mimes' => __('jt.IN-16'),
            'files.max' => __('jt.IN-17', ['size' => '10MB']),
            'start_date.required_without' => __('jt.IN-19'),
            'start_date.before_or_equal' => __('jt.IN-20'),
            'start_date.date' => __('jt.IN-39'),
            'end_date.required_without' => __('jt.IN-21'),
            'end_date.after_or_equal' => __('jt.IN-22'),
            'end_date.date' => __('jt.IN-39'),
            'thumbnail.required' => __('jt.IN-23'),
            'thumbnail.file' => __('jt.IN-24'),
            'thumbnail.image' => __('jt.IN-16'),
            'thumbnail.max' => __('jt.IN-17', ['size' => '2MB']),
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
            'location' => ['nullable', 'max:30'],
            'files.*' => ['nullable', 'file', 'max:10240', 'mimes:zip,ppt,pptx,pdf,jpg,jpeg,png,webp,xlsx'],
            'start_date' => ['nullable', 'required_without:use_always', 'date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'required_without:use_always', 'date', 'after_or_equal:start_date'],
            'thumbnail' => [($this->route('event') ? 'nullable' : 'required'), 'file', 'image', 'max:2048'],
            'status' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function handle(?Event $event)
    {
        $data = $this->validated();

        $data['locale'] = $event?->locale ?? $this->get_locale();
        $data['use_always'] = $this->has('use_always');

        if (empty($data['published_at'])) {
            $data['published_at'] = $event?->published_at ?? now();
        }

        if (is_null($event)) {
            $event = $this->user('admin')->events()->create($data);
        } else {
            $event->update($data);

            if ($this->has('delete_files')) {
                foreach ($this->delete_files as $file_id) {
                    $event->files()->find($file_id)->delete();
                }
            }
        }

        if ($this->hasFile('thumbnail')) {
            $event->update([
                'thumbnail' => $this->file('thumbnail')->storeAs('board/event/' . $event->id, 'thumbnail.' . $this->file('thumbnail')->extension(), 'public'),
            ]);
        }

        if ($this->hasFile('files')) {
            foreach ($this->file('files') as $file) {
                $event->files()->create([
                    'file_mime' => $file->getMimeType(),
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'file_path' => $file->store('board/event/' . $event->id, 'public'),
                ]);
            }
        }
    }
}
