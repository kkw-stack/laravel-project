<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\SceneryGalleryCategory;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class SceneryCategoryRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'name.required' => __('jt.IN-30'),
            'name.unique' => __('jt.IN-31'),
            'description.max' => __('jt.IN-40'),
        ];
    }

    public function rules() : array
    {
        $unique_rule = Rule::unique('board_scenery_categories', 'name')->whereNull('deleted_at')->where(function (Builder $query) {
            return $query->where('locale', $this->get_locale());
        });

        if ($this->route('category')) {
            $unique_rule->ignore($this->route('category')->id);
        }

        return [
            'name' => ['required', 'max:50', $unique_rule],
            'description' => ['nullable', 'max:200'],
        ];
    }

    public function handle(?SceneryGalleryCategory $category)
    {
        $data = $this->validated();

        $data['locale'] = $category?->locale ?? $this->get_locale();

        if (is_null($category)) {
            $this->user('admin')->sceneryCategories()->create($data);
        } else {
            $category->update($data);
        }
    }
}
