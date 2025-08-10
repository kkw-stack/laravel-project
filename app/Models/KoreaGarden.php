<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KoreaGarden extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'locale',
        'title',
        'content',
        'image',
        'image_mobile',
        'video',
        'video_mobile',
        'category_id',
        'status',
        'published_at',
    ];
    protected $casts = [
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
        return $this->belongsTo(KoreaGardenCategory::class, 'category_id');
    }
}
