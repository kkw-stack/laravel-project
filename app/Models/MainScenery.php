<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainScenery extends Model
{
    use HasFactory;

    protected $fillable = [
        'locale',
        'first_post_id',
        'second_post_id',
        'third_post_id',
        'four_post_id',
        'five_post_id',
        'six_post_id',
        'seven_post_id',
        'eight_post_id',
        'nine_post_id',
        'ten_post_id',
    ];

    protected $casts = [
        'first_post_id' => 'integer',
        'second_post_id' => 'integer',
        'third_post_id' => 'integer',
        'four_post_id' => 'integer',
        'five_post_id' => 'integer',
        'six_post_id' => 'integer',
        'seven_post_id' => 'integer',
        'eight_post_id' => 'integer',
        'nine_post_id' => 'integer',
        'ten_post_id' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public static function items(string $locale)
    {
        $result = [];
        $scenery = static::where('locale', $locale)->latest()->first();

        if (!is_null($scenery)) {
            $itemColumns = ['first', 'second', 'third', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten'];

            foreach ($itemColumns as $column) {
                if ($scenery->morphItem($column)->exists()) {
                    $galleryItem = $scenery->morphItem($column)->first();
                    if ($galleryItem) {
                        $result[] = $galleryItem;
                    }
                }
            }
        }

        return $result;
    }

    public static function adminItems(string $locale): array
    {
        $result = [];
        $scenery = static::where('locale', $locale)->latest()->first();

        if ($scenery) {
            $itemColumns = ['first', 'second', 'third', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten'];

            foreach ($itemColumns as $column) {
                if ($scenery->morphItem($column)->exists()) {
                    $result[] = $scenery->{$column . '_post_id'};
                }
            }
        }

        return $result;
    }

    public function morphItem($column)
    {
        return $this->morphScenery("{$column}_post_id");
    }

    private function morphScenery(?string $id)
    {
        return $this->belongsTo(SceneryGallery::class, $id, 'id')->where('status', true)->where('published_at', '<=', now());
    }
}
