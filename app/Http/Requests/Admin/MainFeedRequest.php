<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;

class MainFeedRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'feed_ids.max' => __('jt.IN-26'),
            'feed_ids.*.distinct' => __('jt.IN-51'),
        ];
    }

    public function rules() : array
    {
        return [
            'feed_ids' => ['array', 'max:3'],
            'feed_ids.*' => ['distinct'],
        ];
    }

    public function handle()
    {
        $data = [];

        $data['locale'] = $this->get_locale();

        foreach ($this->validated('feed_ids', []) as $idx => $item) {
            if (0 === $idx) {
                $columnPrefix = 'first';
            } elseif (1 === $idx) {
                $columnPrefix = 'second';
            } elseif (2 === $idx) {
                $columnPrefix = 'third';
            } else {
                break;
            }

            list($type, $id) = explode('_', $item);

            $data["{$columnPrefix}_post_type"] = $type;
            $data["{$columnPrefix}_post_id"] = $id;

        }

        $this->user('admin')->mainFeeds()->create($data);
    }
}
