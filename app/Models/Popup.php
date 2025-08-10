<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Popup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'locale',
        'title',
        'image',
        'use_always',
        'start_date',
        'end_date',
        'url',
        'target',
        'top',
        'left',
        'status',
    ];
    protected $casts = [
        'use_always' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'target' => 'boolean',
        'top' => 'integer',
        'left' => 'integer',
        'status' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }
}
