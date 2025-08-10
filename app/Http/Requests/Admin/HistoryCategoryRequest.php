<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;
use App\Models\HistoryCategory;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class HistoryCategoryRequest extends AdminFormRequest
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
        $unique_rule = Rule::unique('history_categories', 'title')->whereNull('deleted_at')->where(function (Builder $query) {
            return $query->where('locale', $this->get_locale());
        });

        if ($this->route('category')) {
            $unique_rule->ignore($this->route('category')->id);
        }

        return [
            'title' => ['required', 'string', 'max:20', $unique_rule],
            'content' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function handle(?HistoryCategory $category)
    {
        $data = $this->validated();

        $data['locale'] = $category?->locale ?? $this->get_locale();

        if (is_null($category)) {
            $category = $this->user('admin')->historyCategories()->create($data);
        } else {
            $category->update($data);
        }
    }
}
