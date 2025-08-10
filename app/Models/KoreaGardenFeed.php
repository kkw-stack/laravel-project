<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoreaGardenFeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'locale',
        'first_post_id',
        'second_post_id',
        'third_post_id',
    ];

    protected $casts = [
        'first_post_id' => 'integer',
        'second_post_id' => 'integer',
        'third_post_id' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public static function items(string $locale)
    {
        $result = [];

        $feed = static::where('locale', $locale)->latest()->first();

        if (false === is_null($feed)) {
            if ($feed->firstItem()->exists()) {
                $result[] = $feed->firstItem()->first();
            }

            if ($feed->secondItem()->exists()) {
                $result[] = $feed->secondItem()->first();
            }

            if ($feed->thirdItem()->exists()) {
                $result[] = $feed->thirdItem()->first();
            }
        }

        return $result;
    }

    public function firstItem()
    {
        return $this->belongsTo(Event::class, 'first_post_id', 'id')->where('status', true)->where('published_at', '<=', now());
    }

    public function secondItem()
    {
        return $this->belongsTo(Event::class, 'second_post_id', 'id')->where('status', true)->where('published_at', '<=', now());
    }

    public function thirdItem()
    {
        return $this->belongsTo(Event::class, 'third_post_id', 'id')->where('status', true)->where('published_at', '<=', now());
    }
}
