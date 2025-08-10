<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class SceneryGallery extends Model implements Sitemapable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'board_sceneries';

    protected $fillable = [
        'locale',
        'title',
        'thumbnail',
        'scenery_category_id',
        'status',
        'published_at',
    ];

    protected $casts = [
        'scenery_category_id' => 'integer',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function category()
    {
        return $this->belongsTo(SceneryGalleryCategory::class, 'scenery_category_id');
    }

    public function toSitemapTag() : Url|string|array
    {
        $route = $this->locale . 'board.scenery.detail';

        return Url::create(route($route, $this))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
            ->setPriority(0.1);
    }
}
