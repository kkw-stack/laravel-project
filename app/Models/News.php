<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class News extends Model implements Sitemapable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'board_news';

    protected $fillable = [
        'locale',
        'use_link',
        'link',
        'title',
        'content',
        'status',
        'published_at',
    ];

    protected $casts = [
        'use_link' => 'boolean',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    public string $mainLabel = '뉴스';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mainLabel = __('front.news.main');
    }

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function next()
    {
        return self::where('locale', $this->locale)->where('published_at', '<', $this->published_at)->where('use_link', false)->where('published_at', '<=', now())->where('status', true)->orderBy('published_at', 'desc')->first();
    }

    public function prev()
    {
        return self::where('locale', $this->locale)->where('published_at', '>', $this->published_at)->where('use_link', false)->where('published_at', '<=', now())->where('status', true)->orderBy('published_at', 'asc')->first();
    }

    public function url()
    {
        return jt_route('board.news.detail', ['news' => $this]);
    }

    public function toSitemapTag() : Url|string|array
    {
        $route = $this->locale . '.board.news.detail';

        return Url::create(route($route, $this))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
            ->setPriority(0.1);
    }
}
