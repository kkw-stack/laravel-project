<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\KoreaGardenCategory;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class KoreaGardenCategoryRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'title.required' => __('jt.IN-30'),
            'title.unique' => __('jt.IN-31'),
            'title.string' => __('jt.IN-40'),
            'title.max' => __('jt.IN-40'),
            'content.required' => __('jt.IN-25'),
            'content.string' => __('jt.IN-40'),
            'content.max' => __('jt.IN-40'),
        ];
    }

    public function rules() : array
    {
        $unique_rule = Rule::unique('korea_garden_categories', 'title')->whereNull('deleted_at')->where(column: function (Builder $query) {
            return $query->where('locale', $this->get_locale());
        });

        if ($this->route('category')) {
            $unique_rule->ignore($this->route('category')->id);
        }

        return [
            'title' => ['required', 'string', 'max:30', $unique_rule],
            'content' => ['required', 'string', 'max:500'],
        ];
    }

    public function handle(?KoreaGardenCategory $category)
    {
        $data = $this->validated();

        $data['locale'] = $category?->locale ?? $this->get_locale();

        if (is_null($category)) {
            $category = $this->user('admin')->koreaGardenCategories()->create($data);
        } else {
            $category->update($data);
        }
    }
}
