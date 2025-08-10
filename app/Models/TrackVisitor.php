<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackVisitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip',
        'user_agent',
        'url',
        'referer',
    ];
}
