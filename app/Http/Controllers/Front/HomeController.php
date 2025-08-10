<?php

namespace App\Http\Controllers\Front;

use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\MainFeed;
use App\Models\MainVisual;
use App\Models\MainScenery;
use App\Models\Weather;
use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('', 'ko.index')]
    #[Get('en', 'en.index')]
    public function index(Request $request): View
    {
        $locale = $this->get_locale();
        $visuals = MainVisual::where('locale', $locale)->where('status', true)->orderByDesc('order_idx')->latest()->get();
        $feeds = MainFeed::items($locale);
        $popups = Popup::where('locale', $locale)->where('status', true)->orderByDesc('order_idx')->orderBy('created_at')->get();
        $sceneries = MainScenery::items($locale);
        $currentDate = Carbon::now()->locale($locale)->isoFormat('YYYY. MM. DD ' . ($locale === 'en' ? 'ddd' : 'dddd'));
        $weatherData = Weather::latest()->first();

        return view('front.index', compact('visuals', 'feeds', 'popups', 'sceneries', 'weatherData', 'currentDate'));
    }
}
