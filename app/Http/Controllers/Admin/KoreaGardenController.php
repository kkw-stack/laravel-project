<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KoreaGardenCategoryRequest;
use App\Http\Requests\Admin\KoreaGardenFeedRequest;
use App\Http\Requests\Admin\KoreaGardenRequest;
use App\Models\Event;
use App\Models\KoreaGarden;
use App\Models\KoreaGardenCategory;
use App\Models\KoreaGardenFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('garden/hanguk')]
class KoreaGardenController extends Controller
{
    #[Get('feed', 'admin.garden.hanguk.feed.list')]
    public function feed_list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $feed = KoreaGardenFeed::where('locale', $locale)->latest()->first();
        $events = Event::select('id', 'title')->where('locale', $locale)->where('status', true)->where('published_at', '<=', now())->orderByDesc('published_at')->latest()->get();

        return view('admin.garden.hanguk.feed.list', compact('locale', 'feed', 'events'));
    }

    #[Post('feed', 'admin.garden.hanguk.feed.store')]
    public function feed_store(KoreaGardenFeedRequest $request)
    {
        $request->handle();

        return to_route('admin.garden.hanguk.feed.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
    }

    #[Get('category', 'admin.garden.hanguk.category.list')]
    public function category_list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $categories = KoreaGardenCategory::where('locale', $locale)->orderBy('order_idx')->latest()->get();

        return view('admin.garden.hanguk.category.list', compact('locale', 'categories'));
    }

    #[Post('category', 'admin.garden.hanguk.category.store.order')]
    public function category_store_order(Request $request)
    {
        foreach ($request->sort_ids as $idx => $category_id) {
            KoreaGardenCategory::where('id', $category_id)->update(['order_idx' => $idx]);
        }
        return to_route('admin.garden.hanguk.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }

    #[Get('category/create', 'admin.garden.hanguk.category.create')]
    #[Get('category/{category}', 'admin.garden.hanguk.category.detail')]
    public function category_detail(Request $request, ?KoreaGardenCategory $category = null)
    {
        return view('admin.garden.hanguk.category.detail', compact('category'));
    }

    #[Post('category/create', 'admin.garden.hanguk.category.store')]
    #[Post('category/{category}', 'admin.garden.hanguk.category.update')]
    public function category_store(KoreaGardenCategoryRequest $request, ?KoreaGardenCategory $category = null)
    {
        $request->handle($category);

        if (is_null($category)) {
            return to_route('admin.garden.hanguk.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        }

        return to_route('admin.garden.hanguk.category.detail', array_merge($request->query(), compact('category'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
    }

    #[Delete('category/{category}', 'admin.garden.hanguk.category.delete')]
    public function category_delete(Request $request, KoreaGardenCategory $category)
    {
        $category->delete();

        return to_route('admin.garden.hanguk.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }

    #[Get('', 'admin.garden.hanguk.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $search = $request->query('search');
        $searchType = $request->query('search_type', 'title');
        $filterCategory = $request->query('filter_category');

        $query = KoreaGarden::query()->where('locale', $locale);

        if (! empty($filterCategory)) {
            $query->where('category_id', $filterCategory);
        }

        if (! empty($search)) {
            if ($searchType === 'author') {
                $query->whereHas('author', function ($query) use ($search) {
                    $query->where(DB::raw('LOWER(name)'), 'like', '%' . str_replace(' ', '%', $search) . '%');
                });
            } elseif (in_array($searchType, ['title', 'content'])) {
                $query->where($searchType, 'like', '%' . str_replace(' ', '%', $search) . '%');
            }
        }

        $query->orderByDesc('published_at')->latest();

        $gardens = $query->paginate(10);
        $categories = $this->get_categories();

        return view('admin.garden.hanguk.list', compact('locale', 'search', 'searchType', 'filterCategory', 'gardens', 'categories'));
    }

    #[Get('create', 'admin.garden.hanguk.create')]
    #[Get('{garden}', 'admin.garden.hanguk.detail')]
    public function detail(Request $request, ?KoreaGarden $garden = null)
    {
        $categories = $this->get_categories();

        return view('admin.garden.hanguk.detail', compact('garden', 'categories'));
    }

    #[Post('create', 'admin.garden.hanguk.store')]
    #[Post('{garden}', 'admin.garden.hanguk.update')]
    public function store(KoreaGardenRequest $request, ?KoreaGarden $garden = null)
    {
        $request->handle($garden);

        if (is_null($garden)) {
            return to_route('admin.garden.hanguk.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.garden.hanguk.detail', array_merge($request->query(), compact('garden'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{garden}', 'admin.garden.hanguk.delete')]
    public function delete(Request $request, KoreaGarden $garden)
    {
        $garden->delete();

        return to_route('admin.garden.hanguk.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }

    private function get_categories()
    {
        return KoreaGardenCategory::where('locale', $this->get_admin_locale())->orderBy('order_idx')->latest()->get();
    }
}
