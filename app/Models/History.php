<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'locale',
        'category_id',
        'year',
        'content',
        'status',
        'published_at',
    ];
    protected $casts = [
        'category_id' => 'integer',
        'content' => 'array',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function category()
    {
        return $this->belongsTo(HistoryCategory::class, 'category_id');
    }
}
