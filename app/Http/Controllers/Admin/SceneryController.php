<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SceneryRequest;
use App\Http\Requests\Admin\SceneryCategoryRequest;
use App\Models\SceneryGallery;
use App\Models\SceneryGalleryCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('scenery')]
class SceneryController extends Controller
{
    #[Get('category/create', 'admin.scenery.category.create')]
    #[Get('category/{category}', 'admin.scenery.category.detail')]
    public function category_detail(Request $request, ?SceneryGalleryCategory $category = null)
    {
        return view('admin.board.scenery.category.detail', compact('category'));
    }

    #[Post('category/create', 'admin.scenery.category.store')]
    #[Post('category/{category}', 'admin.scenery.category.update')]
    public function category_store(SceneryCategoryRequest $request, ?SceneryGalleryCategory $category = null)
    {
        $request->handle($category);

        if (is_null($category)) {
            return to_route('admin.scenery.category.list', $this->get_admin_locale_params())->with(['success-message' => __('jt.ME-01')]);
        } else {
            return to_route('admin.scenery.category.detail', array_merge($request->query(), compact('category'), $this->get_admin_locale_params()))->with(['success-message' => __('jt.ME-02')]);
        }
    }

    #[Delete('category/{category}', 'admin.scenery.category.delete')]
    public function category_delete(Request $request, SceneryGalleryCategory $category)
    {
        if ($category->sceneries->count() > 0) {
            throw ValidationException::withMessages([
                'common' => __('jt.AL-05', ['count' => $category->sceneries->count()]),
            ]);
        }

        $category->delete();

        return to_route('admin.scenery.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }

    #[Get('category', 'admin.scenery.category.list')]
    public function category_list(Request $request)
    {
        $locale = $this->get_admin_locale();

        $query = SceneryGalleryCategory::query()->where('locale', $locale);
        $query->orderBy('order_idx');
        $query->latest();

        $categories = $query->get();

        return view('admin.board.scenery.category.list', compact('locale', 'categories'));
    }

    #[Post('category', 'admin.scenery.category.store.order')]
    public function category_store_order(Request $request)
    {
        foreach ($request->category_ids as $idx => $category_id) {
            SceneryGalleryCategory::where('id', $category_id)->update(['order_idx' => $idx]);
        }

        return to_route('admin.scenery.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }

    #[Get('', 'admin.scenery.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $search = $request->query('search');
        $search_type = $request->query('search_type', 'title');

        $query = SceneryGallery::query()->where('locale', $locale);

        if (! empty($search)) {
            if ($search_type === 'author') {
                $query->whereHas('author', function ($query) use ($search) {
                    $query->where(DB::raw('LOWER(name)'), 'like', '%' . str_replace(' ', '%', $search) . '%');
                });
            } elseif (in_array($search_type, ['title', 'content'])) {
                $query->where(DB::raw("LOWER({$search_type})"), 'like', '%' . str_replace(' ', '%', $search) . '%');
            }
        }

        $query->orderByDesc('published_at');
        $query->latest();

        $sceneries = $query->paginate(10);
        $categories = $this->get_categories();

        return view('admin.board.scenery.list', compact('locale', 'search', 'search_type', 'sceneries', 'categories'));
    }

    #[Get('create', 'admin.scenery.create')]
    #[Get('{scenery}', 'admin.scenery.detail')]
    public function detail(Request $request, ?SceneryGallery $scenery = null)
    {
        $categories = $this->get_categories();

        return view('admin.board.scenery.detail', compact('scenery', 'categories'));
    }

    #[Post('create', 'admin.scenery.store')]
    #[Post('{scenery}', 'admin.scenery.update')]
    public function store(SceneryRequest $request, ?SceneryGallery $scenery = null)
    {
        $request->handle($scenery);

        if (is_null($scenery)) {
            return to_route('admin.scenery.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.scenery.detail', array_merge($request->query(), compact('scenery'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{scenery}', 'admin.scenery.delete')]
    public function delete(Request $request, SceneryGallery $scenery)
    {
        $scenery->delete();

        return to_route('admin.scenery.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }
    private function get_categories()
    {
        return SceneryGalleryCategory::where('locale', $this->get_admin_locale())->select('id', 'name')->orderBy('order_idx')->latest()->get();
    }
}
