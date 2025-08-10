<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'max_date',
        'max_count',
        'max_docent',
        'summer_start',
        'summer_end',
        'winter_start',
        'winter_end',
        'closed_weekday',
        'closed_dates',
    ];

    protected $casts = [
        'max_date' => 'integer',
        'max_count' => 'integer',
        'max_docent' => 'integer',
        'closed_weekday' => 'array',
        'closed_dates' => 'array',
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
}
