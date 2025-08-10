<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PeopleCategoryRequest;
use App\Http\Requests\Admin\PeopleRequest;
use App\Models\People;
use App\Models\PeopleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('intro/people')]
class PeopleController extends Controller
{
    #[Get('category', 'admin.intro.people.category.list')]
    public function category_list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $categories = PeopleCategory::where('locale', $locale)->orderBy('order_idx')->latest()->get();

        return view('admin.intro.people.category.list', compact('locale', 'categories'));
    }

    #[Post('category', 'admin.intro.people.category.store.order')]
    public function category_store_order(Request $request)
    {
        foreach ($request->sort_ids as $idx => $category_id) {
            PeopleCategory::where('id', $category_id)->update(['order_idx' => $idx]);
        }
        return to_route('admin.intro.people.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }

    #[Get('category/create', 'admin.intro.people.category.create')]
    #[Get('category/{category}', 'admin.intro.people.category.detail')]
    public function category_detail(Request $request, ?PeopleCategory $category = null)
    {
        return view('admin.intro.people.category.detail', compact('category'));
    }

    #[Post('category/create', 'admin.intro.people.category.store')]
    #[Post('category/{category}', 'admin.intro.people.category.update')]
    public function category_store(PeopleCategoryRequest $request, ?PeopleCategory $category = null)
    {
        $request->handle($category);

        if (is_null($category)) {
            return to_route('admin.intro.people.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        }

        return to_route('admin.intro.people.category.detail', array_merge($request->query(), compact('category'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
    }

    #[Delete('category/{category}', 'admin.intro.people.category.delete')]
    public function category_delete(Request $request, PeopleCategory $category)
    {
        $category->delete();

        return to_route('admin.intro.people.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }

    #[Get('', 'admin.intro.people.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $search = $request->query('search');
        $searchType = $request->query('search_type', 'name');
        $filterCategory = $request->query('filter_category');

        $query = People::query()->where('locale', $locale);

        if (! empty($filterCategory)) {
            $query->where('category_id', $filterCategory);
        }

        if (! empty($search)) {
            if ($searchType === 'author') {
                $query->whereHas('author', function ($query) use ($search) {
                    $query->where(DB::raw('LOWER(name)'), 'like', '%' . str_replace(' ', '%', $search) . '%');
                });
            } elseif (in_array($searchType, ['name', 'content'])) {
                $query->where($searchType, 'like', '%' . str_replace(' ', '%', $search) . '%');
            }
        }

        $query->orderByDesc('published_at')->latest();

        $peoples = $query->paginate(10);
        $categories = $this->get_categories();

        return view('admin.intro.people.list', compact('locale', 'search', 'searchType', 'filterCategory', 'peoples', 'categories'));
    }

    #[Get('create', 'admin.intro.people.create')]
    #[Get('{people}', 'admin.intro.people.detail')]
    public function detail(Request $request, ?People $people = null)
    {
        $categories = $this->get_categories();

        return view('admin.intro.people.detail', compact('categories', 'people'));
    }

    #[Post('create', 'admin.intro.people.store')]
    #[Post('{people}', 'admin.intro.people.update')]
    public function store(PeopleRequest $request, ?People $people = null)
    {
        $request->handle($people);

        if (is_null($people)) {
            return to_route('admin.intro.people.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.intro.people.detail', array_merge($request->query(), compact('people'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{people}', 'admin.intro.people.delete')]
    public function delete(Request $request, People $people)
    {
        $people->delete();

        return to_route('admin.intro.people.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }

    private function get_categories()
    {
        return PeopleCategory::where('locale', $this->get_admin_locale())->orderBy('order_idx')->latest()->get();
    }
}
