<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Notice extends Model implements Sitemapable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'board_notices';

    protected $fillable = [
        'locale',
        'is_notice',
        'title',
        'content',
        'status',
        'published_at',
    ];

    protected $casts = [
        'is_notice' => 'boolean',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    public string $mainLabel = '공지';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mainLabel = __('front.notice.main');
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

    public function url()
    {
        return jt_route('board.notice.detail', ['notice' => $this]);
    }

    public function toSitemapTag() : Url|string|array
    {
        $route = $this->locale . '.board.notice.detail';

        return Url::create(route($route, $this))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
            ->setPriority(0.1);
    }
}
