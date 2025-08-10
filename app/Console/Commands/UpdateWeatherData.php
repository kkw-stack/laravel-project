<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\KmaApiService;
use App\Models\Weather;
use Illuminate\Support\Facades\Log;

class UpdateWeatherData extends Command
{
    protected $signature = 'jt:weather:update';
    protected $description = '기상청 날씨 및 대기오염 데이터 업데이트';

    private KmaApiService $kmaApiService;

    public function __construct(KmaApiService $kmaApiService)
    {
        parent::__construct();
        $this->kmaApiService = $kmaApiService;
    }

    public function handle()
    {
        $latitude = 37.5466;
        $longitude = 127.3371;

        // 기상청 날씨 데이터
        $weatherData = $this->kmaApiService->getWeather($latitude, $longitude);
        
        // 한국환경공단 미세먼지 데이터
        $airQualityData = $this->kmaApiService->getAirQuality();

        if (is_null($weatherData) || is_null($airQualityData)) {
            $this->info('데이터 요청 실패. 기존 데이터를 유지합니다.');
            return Command::SUCCESS;
        }

        Weather::updateOrCreate(
            ['location' => '경기도 양평군'],
            [
                'temperature' => $weatherData['temperature'] ?? null,
                'sky' => $weatherData['sky'] ?? null,
                'rain_type' => $weatherData['rain_type'] ?? null,
                'weather_type' => $weatherData['weather_type'] ?? null,
                'pm10' => $airQualityData['pm10'] ?? null,
                'pm25' => $airQualityData['pm25'] ?? null,
                'air_quality' => $airQualityData['air_quality'] ?? null,
                'updated_at' => now(),
            ]
        );

        $this->info('날씨 및 대기오염 데이터가 성공적으로 업데이트되었습니다.');
        return Command::SUCCESS;
    }
}
