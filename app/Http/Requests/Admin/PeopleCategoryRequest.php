<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\PeopleCategory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PeopleCategoryRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-30'),
            'title.unique' => __('jt.IN-31'),
            'title.string' => __('jt.IN-40'),
            'title.max' => __('jt.IN-40'),
            'content.string' => __('jt.IN-40'),
            'content.max' => __('jt.IN-40'),
        ];
    }

    public function rules() : array
    {
        $unique_rule = Rule::unique('people_categories', 'title')->whereNull('deleted_at')->where(function (Builder $query) {
            return $query->where('locale', $this->get_locale());
        });

        if ($this->route('category')) {
            $unique_rule->ignore($this->route('category')->id);
        }

        return [
            'title' => ['required', 'string', 'max:20', $unique_rule],
            'content' => ['nullable', 'string', 'max:10'],
        ];
    }

    public function handle(?PeopleCategory $category)
    {
        $data = $this->validated();

        $data['locale'] = $category?->locale ?? $this->get_locale();

        if (is_null($category)) {
            $category = $this->user('admin')->peopleCategories()->create($data);
        } else {
            $category->update($data);
        }
    }
}
