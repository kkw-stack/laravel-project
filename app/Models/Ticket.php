<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const PRICE_LABELS = [
        'adult' => '성인',
        'college' => '대학(원)생',
        'student' => '중고등학생(만 13~18세)',
        'child' => '미취학 초등학생(직계가족 동반)',
        'child_only' => '미취학 초등학생',
        // 'elder' => '경로',
        // 'disabled' => '장애인',
        // 'national' => '군인/경찰/소방관',
        // 'beneficiary' => '국가유공자/보훈자',
        // 'yangpyeong' => '양평군민',
        // 'yangdong' => '양동면민',
    ];

    public const PRICE_FOREIGN_LABELS = [
        'foreign_adult' => 'Adult',
        'foreign_child' => 'Children Under 2yrs old',
        'foreign_elder' => 'Under 18 yrs old',
        'foreign_student' => 'Students(full-time)'
    ];

    protected $fillable = [
        'title',
        'sector',
        'price',
        'time_table',
        'use_night_time_table',
        'night_start_date',
        'night_end_date',
        'night_time_table',
        'disable_time_table',
        'status',
    ];
    protected $casts = [
        'title' => 'array',
        'sector' => 'array',
        'price' => 'array',
        'time_table' => 'array',
        'use_night_time_table' => 'boolean',
        'night_time_table' => 'array',
        'disable_time_table' => 'array',
        'status' => 'boolean',
    ];
    protected $hidden = [
        'manager_id',
        'order_idx',
        'status',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'ticket_id');
    }
}
