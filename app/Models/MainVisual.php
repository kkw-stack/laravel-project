<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainVisual extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'locale',
        'title',
        'thumbnail',
        'thumbnail_mobile',
        'video',
        'video_mobile',
        'weather_icon',
        'description',
        'order_idx',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order_idx' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }
}
