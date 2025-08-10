<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Event extends Model implements Sitemapable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'board_events';

    protected $fillable = [
        'locale',
        'title',
        'content',
        'location',
        'use_always',
        'start_date',
        'end_date',
        'thumbnail',
        'status',
        'published_at',
    ];

    protected $casts = [
        'use_always' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    public string $mainLabel = '행사';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mainLabel = __('front.event.main');
    }

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function files()
    {
        return $this->morphMany(BoardFile::class, 'board');
    }

    public function next()
    {
        return self::where('locale', $this->locale)->where('published_at', '<', $this->published_at)->where('published_at', '<=', now())->where('status', true)->orderBy('published_at', 'desc')->first();
    }

    public function prev()
    {
        return self::where('locale', $this->locale)->where('published_at', '>', $this->published_at)->where('published_at', '<=', now())->where('status', true)->orderBy('published_at', 'asc')->first();
    }

    public function latest_items()
    {
        return self::where('locale', $this->locale)->where('published_at', '<=', now())->where('status', true)->where('id', '<>', $this->id)->orderBy('published_at', 'desc')->limit(4)->get();
    }

    public function url()
    {
        return jt_route('board.event.detail', ['event' => $this]);
    }

    public function currentStatusLabel() : string
    {
        if ($this->use_always) {
            return '상시';
        } elseif ($this->end_date < now()) {
            return '종료';
        } elseif ($this->start_date > now()) {
            return '진행예정';
        }

        return '진행중';
    }

    public function currentStatusGardenLabel() : string
    {
        if ($this->use_always) {
            return '진행';
        } elseif ($this->end_date < now()) {
            return '종료';
        } elseif ($this->start_date > now()) {
            return '예정';
        }

        return '진행';
    }

    public function toSitemapTag() : Url|string|array
    {
        $route = $this->locale . 'board.event.detail';

        return Url::create(route($route, $this))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
            ->setPriority(0.1);
    }
}
