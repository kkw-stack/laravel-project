<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\KoreaGardenCategory;
use App\Models\KoreaGardenFeed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class GardenController extends Controller
{
    #[Get('garden/hanguk-garden', 'ko.garden.korea')]
    #[Get('en/garden/hanguk-garden', 'en.garden.korea')]
    public function korea(Request $request)
    {
        $locale = $this->get_locale();
        $events = KoreaGardenFeed::items($locale);
        $categories = KoreaGardenCategory::query()
            ->where('locale', $locale)
            ->whereHas(
                'koreaGardens',
                function (Builder $query) use ($locale) {
                    $query->where('locale', $locale)->where('status', true)->where('published_at', '<=', now());
                }
            )
            ->with([
                'koreaGardens' => function (HasMany $query) use ($locale) {
                    $query->where('locale', $locale)->where('status', true)->where('published_at', '<=', now())->orderByDesc('published_at')->latest();
                }
            ])
            ->orderBy('order_idx')->latest()
            ->get();

        return view('front.garden.korea', compact('events', 'categories'));
    }
}
