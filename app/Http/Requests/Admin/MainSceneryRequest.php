<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;

class MainSceneryRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'scenery_ids.max' => __('jt.IN-26'),
            'scenery_ids.*.distinct' => __('jt.IN-51'),
        ];
    }

    public function rules() : array
    {
        return [
            'scenery_ids' => ['array', 'max:10'],
            'scenery_ids.*' => ['distinct'],
        ];
    }

    public function handle(): void
    {
        $data = [];
        $data['locale'] = $this->get_locale();

        $columnPrefixes = ['first', 'second', 'third', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten'];

        foreach ($this->validated('scenery_ids', []) as $idx => $item) {
            if ($idx >= 10) break;

            $columnPrefix = $columnPrefixes[$idx];

            list($id) = explode('_', $item);
            
            $data["{$columnPrefix}_post_id"] = $id;
        }

        $this->user('admin')->mainSceneries()->create($data);
    }
}
