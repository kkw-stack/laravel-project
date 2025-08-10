<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('reservation')]
class ReservationController extends Controller
{
    #[Post('calendar', 'admin.api.reservation.calendar')]
    public function calendar(Request $request)
    {
        $year = sprintf('%04d', $request->input('year', Carbon::now()->format('Y')));
        $month = sprintf('%02d', $request->input('month', Carbon::now()->format('m')));

        $query = Reservation::query();

        $query->whereNotNull('paid_at');
        $query->whereNull('canceled_at');
        $query->where('select_date', '>=', "{$year}-{$month}-01");
        $query->where('select_date', '<=', "{$year}-{$month}-31");
        $query->groupBy('select_date');

        $data = [
            'total' => $query->clone()->get(['select_date', DB::raw('COUNT(*) AS `count`')])->toArray(),
            'docent_total' => $query->clone()->where('use_docent', true)->get(['select_date', DB::raw('COUNT(*) AS `count`')])->toArray(),
        ];

        return $data;
    }
}
