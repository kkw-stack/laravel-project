<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrackVisitor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('statics')]
class StaticsController extends Controller
{
    #[Get('', 'admin.statics.index')]
    public function index(Request $request)
    {
        $today_visitors = TrackVisitor::select(DB::raw('COUNT(DISTINCT ip) as visit_count'))
            ->whereDate('created_at', Carbon::today())
            ->groupBy(DB::raw('DATE(created_at)')) // 날짜별로 그룹화
            ->get()
            ->sum('visit_count');

        $total_visitors = TrackVisitor::select(DB::raw('COUNT(DISTINCT ip) as visit_count'))
            ->groupBy(DB::raw('DATE(created_at)')) // 날짜별로 그룹화
            ->get()
            ->sum('visit_count');

        $total_users = User::count();
        $ko_users = User::whereNotNull('mobile')->count();
        $en_users = User::whereNull('mobile')->count();

        $sns_users = User::whereNotNull('kakao_id')->orWhereNotNull('naver_id')->orWhereNotNull('google_id')->count();
        $kakao_users = User::whereNotNull('kakao_id')->count();
        $naver_users = User::whereNotNull('naver_id')->count();
        $google_users = User::whereNotNull('google_id')->count();

        DB::enableQueryLog();

        $age_counts = [
            [
                'x' => '20대 이하',
                'y' => User::whereDate('birth', '>', Carbon::today()->subYears(20))->count(),
            ],
            [
                'x' => '20대',
                'y' => User::whereBetween('birth', [Carbon::today()->subYears(29), Carbon::today()->subYears(20),])->count(),
            ],
            [
                'x' => '30대',
                'y' => User::whereBetween('birth', [Carbon::today()->subYears(39), Carbon::today()->subYears(30),])->count(),
            ],
            [
                'x' => '40대',
                'y' => User::whereBetween('birth', [Carbon::today()->subYears(49), Carbon::today()->subYears(40),])->count(),
            ],
            [
                'x' => '50대',
                'y' => User::whereBetween('birth', [Carbon::today()->subYears(59), Carbon::today()->subYears(50),])->count(),
            ],
            [
                'x' => '60대',
                'y' => User::whereBetween('birth', [Carbon::today()->subYears(69), Carbon::today()->subYears(60),])->count(),
            ],
            [
                'x' => '70대',
                'y' => User::whereBetween('birth', [Carbon::today()->subYears(79), Carbon::today()->subYears(70),])->count(),
            ],
            [
                'x' => '80대 이상',
                'y' => User::whereDate('birth', '<=', Carbon::today()->subYears(80))->count(),
            ],
        ];

        $gender_counts = [
            [
                'x' => '남성',
                'y' => User::where('gender', true)->count(),
            ],
            [
                'x' => '여성',
                'y' => User::where('gender', false)->count()
            ],
        ];

        $locations = [
            '서울특별시',
            '부산광역시',
            '인천광역시',
            '대구광역시',
            '대전광역시',
            '광주광역시',
            '울산광역시',
            '세종특별자치시',
            '경기도',
            '강원특별자치도',
            '충청북도',
            '충청남도',
            '전북특별자치도',
            '전라남도',
            '경상북도',
            '경상남도',
            '제주특별자치도',
        ];
        $location_counts = [];
        foreach ($locations as $location) {
            $location_counts[] = [
                'x' => $location,
                'y' => User::where('location', $location)->count(),
            ];
        }

        return view('admin.statics.main', compact(
            'total_visitors',
            'today_visitors',
            'total_users',
            'ko_users',
            'en_users',
            'sns_users',
            'kakao_users',
            'naver_users',
            'google_users',
            'age_counts',
            'gender_counts',
            'location_counts',
        ));
    }
}
