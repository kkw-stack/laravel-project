<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\HistoryCategory;
use App\Models\People;
use App\Models\PeopleCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class IntroduceController extends Controller
{
    #[Get('introduce/about', 'ko.introduce.about')]
    #[Get('en/introduce/about', 'en.introduce.about')]
    public function about(Request $request)
    {
        return view('front.introduce.about', []);
    }

    #[Get('introduce/history', 'ko.introduce.history')]
    #[Get('en/introduce/history', 'en.introduce.history')]
    public function history(Request $request)
    {
        $categories = HistoryCategory::where('locale', $this->get_locale())->orderBy('order_idx')->latest()->get();
        return view('front.introduce.history', compact('categories'));
    }

    #[Get('introduce/people', 'ko.introduce.people')]
    #[Get('en/introduce/people', 'en.introduce.people')]
    public function people(Request $request)
    {
        $locale = $this->get_locale();
        $query = People::query()->where('locale', $locale);
        $query->where('status', true);
        $query->orderByDesc('published_at')->latest();

        $people = $query->get();

        $categories = PeopleCategory::query()
            ->whereHas(
                'people',
                function (Builder $query) use ($locale) {
                    $query->where('locale', $locale)->where('status', true)->where('published_at', '<=', now());
                }
            )
            ->with([
                'people' => function (HasMany $query) use ($locale) {
                    $query->where('locale', $locale)->where('status', true)->where('published_at', '<=', now())->orderByDesc('published_at')->latest();
                }
            ])
            ->orderBy('order_idx')->latest()
            ->get();

        return view('front.introduce.people', compact('people', 'categories'));
    }

    #[Get('introduce/people/{people}', 'ko.introduce.people.detail')]
    #[Get('en/introduce/people/{people}', 'en.introduce.people.detail')]
    public function people_detail(Request $request, People $people)
    {
        if (! $people->status || $people->published_at > now() || $people->locale !== $this->get_locale()) {
            abort(404);
        }

        return view('front.introduce.people-detail', compact('people'));
    }

    #[Get('introduce/sustainability', 'ko.introduce.sustainability')]
    #[Get('en/introduce/sustainability', 'en.introduce.sustainability')]
    public function sustainability(Request $request)
    {
        return view('front.introduce.sustainability', []);
    }
}
