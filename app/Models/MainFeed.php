<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainFeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'locale',
        'first_post_type',
        'first_post_id',
        'second_post_type',
        'second_post_id',
        'third_post_type',
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

        // if (count($result) < 3) {
        //     $result = collect($result)->merge(
        //         Notice::where('status', true)
        //             ->where('published_at', '<=', now())
        //             ->whereNotIn('id', array_map(fn ($item) => $item->id, array_filter($result, fn ($item) => $item instanceof Notice)))
        //             ->orderByDesc('published_at')
        //             ->latest()
        //             ->limit(3 - count($result))
        //             ->get()
        //     );
        // }

        return $result;
    }

    public static function adminItems(string $locale) : array
    {
        $result = [];

        $feed = static::where('locale', $locale)->latest()->first();

        if (false === is_null($feed)) {
            if ($feed->firstItem()->exists()) {
                $result[] = $feed->first_post_type . '_' . $feed->first_post_id;
            }

            if ($feed->secondItem()->exists()) {
                $result[] = $feed->second_post_type . '_' . $feed->second_post_id;
            }

            if ($feed->thirdItem()->exists()) {
                $result[] = $feed->third_post_type . '_' . $feed->third_post_id;
            }
        }

        return $result;
    }

    public function firstItem()
    {
        return $this->morphFeed($this->first_post_type, 'first_post_id');
    }

    public function secondItem()
    {
        return $this->morphFeed($this->second_post_type, 'second_post_id');
    }

    public function thirdItem()
    {
        return $this->morphFeed($this->third_post_type, 'third_post_id');
    }

    private function morphFeed(?string $type, ?string $id)
    {
        if ('notice' === $type) {
            return $this->belongsTo(Notice::class, $id, 'id')->where('status', true)->where('published_at', '<=', now());
        } elseif ('news' === $type) {
            return $this->belongsTo(News::class, $id, 'id')->where('status', true)->where('published_at', '<=', now());
        } elseif ('event' === $type) {
            return $this->belongsTo(Event::class, $id, 'id')->where('status', true)->where('published_at', '<=', now());
        }

        return $this->belongsTo(Notice::class, $id, 'id')->whereNull('id');
    }
}
