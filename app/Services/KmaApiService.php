<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KmaApiService
{
    private string $baseUrl = 'http://apis.data.go.kr/1360000/VilageFcstInfoService_2.0/getUltraSrtFcst';
    private string $airKoreaUrl = 'http://apis.data.go.kr/B552584/ArpltnInforInqireSvc/getCtprvnRltmMesureDnsty';

    public function getWeather(float $latitude, float $longitude): ?array
    {
        $apiKey = config('jt.kma_apikey');
        
        $grid = $this->latLonToGrid($latitude, $longitude);

        $response = Http::get($this->baseUrl, [
            'serviceKey' => $apiKey,
            'numOfRows'  => 100,
            'pageNo'     => 1,
            'dataType'   => 'JSON',
            'base_date'  => now()->format('Ymd'),
            'base_time'  => $this->getBaseTime(),
            'nx'         => $grid['x'],
            'ny'         => $grid['y'],
        ]);

        return $this->parseWeatherData(data_get($response->json(), 'response.body.items.item', []));
    }

    public function getAirQuality(): ?array
    {
        $apiKey = config('jt.kma_apikey');
    
        $response = Http::get($this->airKoreaUrl, [
            'serviceKey' => $apiKey,
            'returnType' => 'json',
            'sidoName'   => '경기',
            'numOfRows'  => 100,
            'pageNo'     => 1,
            'ver'        => '1.3',
        ]);
    
        $items = collect(data_get($response->json(), 'response.body.items', []));
        $preferredStations = ['양평읍', '화도읍', '와부읍', '곤지암', '오남읍'];

        foreach ($preferredStations as $name) {
            $station = $items->firstWhere('stationName', $name);
        
            if ($station && ($station['pm10Value'] ?? '-') !== '-' && '통신장애' !== ($station['pm10Flag'] ?? '')) {
                return $this->parseAirQualityData([$station]);
            }
        }        
    
        return null;
    }
    
    private function parseAirQualityData(array $items): array
    {
        $data = [
            'pm10' => null,
            'pm25' => null,
            'air_quality' => null,
        ];
    
        foreach ($items as $item) {
            if (isset($item['pm10Value']) && isset($item['pm25Value'])) {
                $data['pm10'] = (int) $item['pm10Value'];
                $data['pm25'] = (int) $item['pm25Value'];
                $data['air_quality'] = $this->mapFineDustLevel((int) $item['pm10Value']);
                break;
            }
        }
    
        return $data;
    }    

    private function mapFineDustLevel(int $value): string
    {
        return match (true) {
            $value <= 30  => '좋음',
            $value <= 80  => '보통',
            $value <= 150 => '나쁨',
            default       => '매우 나쁨',
        };
    }

    private function parseWeatherData(array $items): array
    {
        $now = now();
        $nowDate = $now->format('Ymd');
        $nowHour = (int) $now->format('H') * 100;
    
        $filtered = collect($items)
            ->filter(fn($item) => $item['fcstDate'] === $nowDate && (int)$item['fcstTime'] >= $nowHour)
            ->groupBy('category')
            ->map(fn($group) => $group->sortBy('fcstTime')->first());
    
        $sky  = isset($filtered['SKY']) ? $this->mapSkyCode($filtered['SKY']['fcstValue']) : null;
        $rain = isset($filtered['PTY']) ? $this->mapRainType($filtered['PTY']['fcstValue']) : null;
    
        return [
            'temperature'   => $filtered['T1H']['fcstValue'] ?? null,
            'sky'           => $sky ?? null,
            'rain_type'     => $rain ?? null ,
            'weather_type'  => $this->getWeatherType($sky, $rain),
        ];
    }
    
    private function getBaseTime(): string
    {
        $minute = now()->minute;
        $baseHour = now()->hour;
    
        if ($minute < 40) {
            $baseHour = now()->subHour()->hour;
        }
    
        return sprintf('%02d00', $baseHour);
    }
    
    private function mapSkyCode(string $code): string
    {
        return match ($code) {
            '1' => '맑음',
            '3' => '구름 많음',
            '4' => '흐림',
            default => null,
        };
    }

    private function mapRainType(string $code): string
    {
        return match ($code) {
            '0' => '강수 없음',
            '1' => '비',
            '2' => '비/눈',
            '3' => '눈',
            '4' => '소나기',
            default => null,
        };
    }

    private function getWeatherType(?string $sky, ?string $rainType): string
    {
        return match ($rainType) {
            '비' => 'rain',
            '비/눈' => 'rain-snow',
            '눈' => 'snow',
            '소나기' => 'shower',
            default => match ($sky) {
                '맑음' => 'sunny',
                '구름 많음' => 'cloudy',
                '흐림' => 'overcast',
                default => null,
            }
        };
    }

    private function latLonToGrid(float $lat, float $lon): array
    {
        $RE = 6371.00877; // 지구 반경 (km)
        $GRID = 5.0; // 격자 간격 (km)
        $SLAT1 = 30.0; // 표준위도 1
        $SLAT2 = 60.0; // 표준위도 2
        $OLON = 126.0; // 기준점 경도
        $OLAT = 38.0; // 기준점 위도
        $XO = 43; // 기준점 X좌표 (격자)
        $YO = 136; // 기준점 Y좌표 (격자)
        $DEGRAD = M_PI / 180.0;

        $re = $RE / $GRID;
        $slat1 = $SLAT1 * $DEGRAD;
        $slat2 = $SLAT2 * $DEGRAD;
        $olon = $OLON * $DEGRAD;
        $olat = $OLAT * $DEGRAD;

        $sn = log(cos($slat1) / cos($slat2)) / log(tan(M_PI * 0.25 + $slat2 * 0.5) / tan(M_PI * 0.25 + $slat1 * 0.5));
        $sf = pow(tan(M_PI * 0.25 + $slat1 * 0.5), $sn) * cos($slat1) / $sn;
        $ro = $re * $sf / pow(tan(M_PI * 0.25 + $olat * 0.5), $sn);

        // 위도, 경도 -> 격자 변환
        $ra = $re * $sf / pow(tan(M_PI * 0.25 + $lat * $DEGRAD * 0.5), $sn);
        $theta = ($lon * $DEGRAD - $olon) * $sn;

        return [
            'x' => (int) floor($ra * sin($theta) + $XO + 0.5),
            'y' => (int) floor($ro - $ra * cos($theta) + $YO + 0.5),
        ];
    }
}