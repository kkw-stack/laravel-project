<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\VisitorGuide;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class ManualController extends Controller
{
    public function __construct()
    {
        if (! $this->is_dev()) {
            abort(404);
        }
    }

    #[Get('manual/visitor-guide', 'ko.manual.visitor-guide')]
    #[Get('en/manual/visitor-guide', 'en.manual.visitor-guide')]
    public function visitor_guide(Request $request)
    {
        $locale = $this->get_locale();
        $guides = VisitorGuide::query()
            ->where('locale', $locale)
            ->where('revision_id', 0)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->orderBy('order_idx')
            ->orderByDesc('published_at')
            ->latest()
            ->get();

        return view('front.manual.visitor-guide', compact('guides'));
    }

    #[Get('manual/food-and-beverage', 'ko.manual.food-and-beverage')]
    #[Get('en/manual/food-and-beverage', 'en.manual.food-and-beverage')]
    public function food_and_beverage(Request $request)
    {
        return view('front.manual.food-and-beverage', []);
    }

    #[Get('manual/faq', 'ko.manual.faq')]
    #[Get('en/manual/faq', 'en.manual.faq')]
    public function faq(Request $request)
    {
        $locale = $this->get_locale();
        $cate = intval($request->query('cate'));
        $categories = FaqCategory::where('locale', $locale)->select('id', 'name')->has('faqs')->orderBy('order_idx')->latest()->get();

        $query = Faq::where('locale', $locale)->select('question', 'answer');

        if ($cate > 0 && FaqCategory::where('locale', $locale)->where('id', $cate)->exists()) {
            $query->where('faq_category_id', $cate);
        }

        $query->where('status', true)->where('published_at', '<=', now());

        $query->orderByDesc('published_at');
        $query->latest();

        $faqs = $query->paginate(10);

        if ($faqs->currentPage() > $faqs->lastPage()) {
            return $this->to_route('manual.faq', array_merge($request->query(), ['page' => $faqs->lastPage()]));
        }

        return view('front.manual.faq', compact('cate', 'categories', 'faqs'));
    }

    #[Get('manual/location', 'ko.manual.location')]
    #[Get('en/manual/location', 'en.manual.location')]
    public function location(Request $request)
    {
        return view('front.manual.location', []);
    }

    #[Get('manual/local-attractions', 'ko.manual.local-attractions')]
    #[Get('en/manual/local-attractions', 'en.manual.local-attractions')]
    public function local_attractions(Request $request)
    {
        $locale = $this->get_locale();

        $attractions = Attraction::query()
            ->where('locale', $locale)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->orderBy('order_idx')
            ->orderByDesc('published_at')
            ->latest()
            ->get();

        return view('front.manual.local-attractions', compact('attractions'));
    }

    #[Get('manual/wedding', 'ko.manual.wedding')]
    #[Get('en/manual/wedding', 'en.manual.wedding')]
    public function wedding(Request $request)
    {
        if (! $this->is_dev()) {
            abort(404);
        }
        return view('front.manual.wedding', []);
    }

    #[Get('manual/venue-rentals', 'ko.manual.venue-rentals')]
    #[Get('en/manual/venue-rentals', 'en.manual.venue-rentals')]
    public function venue_rentals(Request $request)
    {
        if (! $this->is_dev()) {
            abort(404);
        }
        return view('front.manual.venue-rentals', []);
    }
}
