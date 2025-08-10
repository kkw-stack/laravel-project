<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class People extends Model implements Sitemapable
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'locale',
        'category_id',
        'name',
        'intro',
        'thumbnail',
        'use_video',
        'image',
        'video',
        'content',
        'masterpiece',
        'project',
        'status',
        'published_at',
    ];
    protected $casts = [
        'project' => 'array',
        'use_video' => 'boolean',
        'category_id' => 'integer',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function category()
    {
        return $this->belongsTo(PeopleCategory::class, 'category_id');
    }

    public function files()
    {
        return $this->morphMany(BoardFile::class, 'board');
    }

    public function toSitemapTag() : Url|string|array
    {
        $route = $this->locale . '.introduce.people.detail';

        return Url::create(route($route, $this))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
            ->setPriority(0.1);
    }
}
