<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HistoryCategoryRequest;
use App\Http\Requests\Admin\HistoryRequest;
use App\Models\History;
use App\Models\HistoryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('intro/history')]
class HistoryController extends Controller
{
    #[Get('category', 'admin.intro.history.category.list')]
    public function category_list(Request $request) : View
    {
        $locale = $this->get_admin_locale();
        $categories = HistoryCategory::where('locale', $locale)->orderBy('order_idx')->latest()->get();

        return view('admin.intro.history.category.list', compact('locale', 'categories'));
    }

    #[Post('category', 'admin.intro.history.category.store.order')]
    public function category_store_order(Request $request) : RedirectResponse
    {
        foreach ($request->sort_ids as $idx => $category_id) {
            HistoryCategory::where('id', $category_id)->update(['order_idx' => $idx]);
        }

        return to_route('admin.intro.history.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }

    #[Get('category/create', 'admin.intro.history.category.create')]
    #[Get('category/{category}', 'admin.intro.history.category.detail')]
    public function category_detail(Request $request, ?HistoryCategory $category = null) : View
    {
        return view('admin.intro.history.category.detail', compact('category'));
    }

    #[Post('category/create', 'admin.intro.history.category.store')]
    #[Post('category/{category}', 'admin.intro.history.category.update')]
    public function category_store(HistoryCategoryRequest $request, ?HistoryCategory $category = null) : RedirectResponse
    {
        $request->handle($category);

        if (is_null($category)) {
            return to_route('admin.intro.history.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        }

        return to_route('admin.intro.history.category.detail', array_merge($request->query(), compact('category'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
    }

    #[Delete('category/{category}', 'admin.intro.history.category.delete')]
    public function category_delete(Request $request, HistoryCategory $category) : RedirectResponse
    {
        $category->delete();

        return to_route('admin.intro.history.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }

    #[Get('', 'admin.intro.history.list')]
    public function list(Request $request) : View
    {
        $locale = $this->get_admin_locale();
        $search = $request->query('search');
        $search_type = $request->query('search_type', 'title');
        $filter_category = $request->query('filter_category');

        $categories = $this->get_categories();

        $query = History::query()->where('locale', $locale);

        if (! empty($filter_category)) {
            $query->where('category_id', $filter_category);
        }

        if (! empty($search)) {
            if ($search_type === 'author') {
                $query->whereHas('author', function ($query) use ($search) {
                    $query->where(DB::raw('LOWER(name)'), 'like', '%' . str_replace(' ', '%', $search) . '%');
                });
            } else {
                $query->where('year', 'like', '%' . str_replace(' ', '%', $search) . '%');
            }
        }

        $query->orderByDesc('published_at')->latest();

        $histories = $query->paginate(10);

        return view('admin.intro.history.list', compact('locale', 'search', 'search_type', 'filter_category', 'histories', 'categories'));
    }

    #[Get('create', 'admin.intro.history.create')]
    #[Get('{history}', 'admin.intro.history.detail')]
    public function detail(Request $request, ?History $history = null) : View
    {
        $categories = $this->get_categories();

        return view('admin.intro.history.detail', compact('categories', 'history'));
    }

    #[Post('create', 'admin.intro.history.store')]
    #[Post('{history}', 'admin.intro.history.update')]
    public function store(HistoryRequest $request, ?History $history = null) : RedirectResponse
    {
        $request->handle($history);

        if (is_null($history)) {
            return to_route('admin.intro.history.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        }

        return to_route('admin.intro.history.detail', array_merge($request->query(), compact('history'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
    }

    #[Delete('{history}', 'admin.intro.history.delete')]
    public function delete(Request $request, History $history) : RedirectResponse
    {
        $history->delete();

        return to_route('admin.intro.history.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }

    private function get_categories()
    {
        return HistoryCategory::where('locale', $this->get_admin_locale())->orderBy('order_idx')->latest()->get();
    }
}
