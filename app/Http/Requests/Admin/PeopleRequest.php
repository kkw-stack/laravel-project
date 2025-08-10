<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\People;

class PeopleRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'name.required' => __('jt.IN-10'),
            'name.max' => __('jt.IN-40'),
            'intro.required' => __('jt.IN-27'),
            'intro.max' => __('jt.IN-40'),
            'thumbnail.required' => __('jt.IN-23'),
            'thumbnail.mimes' => __('jt.IN-16'),
            'thumbnail.max' => __('jt.IN-17'),
            'image.required_with' => __('jt.IN-23'),
            'image.mimes' => __('jt.IN-16'),
            'image.max' => __('jt.IN-17'),
            'files.mimes' => __('jt.IN-16'),
            'files.max' => __('jt.IN-17', ['size' => '10MB']),
            'content.required' => __('jt.IN-14'),
            'content.max' => __('jt.IN-40'),
            'masterpiece.max' => __('jt.IN-40'),
            'project.*.image.*.mimes' => __('jt.IN-16'),
            'project.*.image.*.max' => __('jt.IN-17'),
            'project.*.explanation.required' => __('jt.IN-25'),
            'project.*.explanation.max' => __('jt.IN-40'),
            'category_id.required' => __('jt.IN-29'),
            'category_id.exists' => __('jt.IN-43'),
            'status.required' => __('jt.IN-37'),
            'status.boolean' => __('jt.IN-37'),
            'published_at.date' => __('jt.IN-39'),
        ];
    }

    public function rules() : array
    {
        $people = $this->route('people');
        $isUpdate = $people instanceof People;
        $use_video = $this->input('use_video');
        $file_image = $this->file('image');

        $current_image = $isUpdate ? $people->getAttribute('image') : null;

        return [
            'name' => ['required', 'max:50'],
            'intro' => ['required', 'max:50'],
            'thumbnail' => [$isUpdate ? 'nullable' : 'required', 'image', 'max:2048'],
            'use_video' => ['boolean'],
            'image' => [
                $isUpdate ? 'nullable' : 'required_with:use_video', 'image', 'max:2048',
                $use_video && ! $file_image && ! $current_image ? 'required_with:use_video' : 'nullable',
            ],
            'video' => ['nullable'],
            'files.*' => ['nullable', 'file', 'max:10240', 'mimes:zip,ppt,pptx,pdf,jpg,jpeg,png,webp,xlsx'],
            'content' => ['required', 'string', 'max:1000'],
            'masterpiece' => ['nullable', 'max:200'],
            'project.*.image' => ['nullable', 'image', 'max:2048'],
            'project.*.explanation' => ['required', 'string', 'max:50'],
            'category_id' => ['required', 'exists:people_categories,id'],
            'status' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function handle(?People $people)
    {
        $data = $this->validated();

        $data['locale'] = $people?->locale ?? $this->get_locale();

        ksort($data['project']);

        $data['use_video'] = $this->has('use_video');

        if ($this->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->file('thumbnail')->store('people', 'public');
        }

        if ($data['use_video'] == 0 && empty($data['image'])) {
            $data['image'] = '';
        }

        if ($this->hasFile('image')) {
            $data['image'] = $this->file('image')->store('people', 'public');
        }

        foreach ($data['project'] as $idx => $value) {
            $data['project'][$idx]['image'] = $this->hasFile("project.{$idx}.image") ? $this->file("project.{$idx}.image")->store('people/project', 'public') : $this->input("project.{$idx}.image_path");
        }

        if (empty($data['published_at'])) {
            $data['published_at'] = $people?->published_at ?? now();
        }

        if (is_null($people)) {
            $people = $this->user('admin')->people()->create($data);
        } else {
            $people->update($data);

            if ($this->has('delete_files')) {
                foreach ($this->delete_files as $file_id) {
                    $people->files()->find($file_id)->delete();
                }
            } elseif ($this->hasFile('files') && $people->files->isNotEmpty()) {
                $people->files->first()->delete();
            }
        }

        if ($this->hasFile('files')) {
            $file = $this->file('files');

            $people->files()->create([
                'file_mime' => $file->getMimeType(),
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_path' => $file->store('people/file/' . $people->id, 'public'),
            ]);
        }
    }
}
