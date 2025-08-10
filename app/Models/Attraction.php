<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attraction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'locale',
        'title',
        'content',
        'source',
        'distance',
        'thumbnail',
        'status',
        'published_at',
    ];
    protected $casts = [
        'distance' => 'integer',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }
}
