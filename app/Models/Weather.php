<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $table = 'weather';

    protected $fillable = [
        'location',
        'temperature',
        'sky',
        'rain_type',
        'weather_type',
        'pm10',
        'pm25',
        'air_quality',
        'updated_at',
    ];

    public function getAirQualityAttribute($value): string
    {
        if (app()->isLocale('en')) {
            return match ($value) {
                '좋음' => 'Low',
                '보통' => 'Moderate',
                '나쁨' => 'High',
                '매우 나쁨' => 'Very High',
                default => $value,
            };
        }

        return $value;
    }
}
