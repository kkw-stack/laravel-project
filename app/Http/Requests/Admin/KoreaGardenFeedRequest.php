<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminFormRequest;

class KoreaGardenFeedRequest extends AdminFormRequest
{
    public function messages() : array
    {
        return [
            'feed_ids.max' => __('jt.IN-26'),
        ];
    }

    public function rules() : array
    {
        return [
            'feed_ids' => ['array', 'max:3'],
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

            $data["{$columnPrefix}_post_id"] = $item;

        }

        $this->user('admin')->koreaGardenFeeds()->create($data);
    }
}
