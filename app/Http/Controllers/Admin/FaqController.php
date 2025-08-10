<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqCategoryRequest;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('faq')]
class FaqController extends Controller
{
    #[Get('category/create', 'admin.faq.category.create')]
    #[Get('category/{category}', 'admin.faq.category.detail')]
    public function category_detail(Request $request, ?FaqCategory $category = null)
    {
        return view('admin.faq.category.detail', compact('category'));
    }

    #[Post('category/create', 'admin.faq.category.store')]
    #[Post('category/{category}', 'admin.faq.category.update')]
    public function category_store(FaqCategoryRequest $request, ?FaqCategory $category = null)
    {
        $request->handle($category);

        if (is_null($category)) {
            return to_route('admin.faq.category.list', $this->get_admin_locale_params())->with(['success-message' => __('jt.ME-01')]);
        } else {
            return to_route('admin.faq.category.detail', array_merge($request->query(), compact('category'), $this->get_admin_locale_params()))->with(['success-message' => __('jt.ME-02')]);
        }
    }

    #[Delete('category/{category}', 'admin.faq.category.delete')]
    public function category_delete(Request $request, FaqCategory $category)
    {
        if ($category->faqs->count() > 0) {
            throw ValidationException::withMessages([
                'common' => __('jt.AL-05', ['count' => $category->faqs->count()]),
            ]);
        }

        $category->delete();

        return to_route('admin.faq.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }

    #[Get('category', 'admin.faq.category.list')]
    public function category_list(Request $request)
    {
        $locale = $this->get_admin_locale();

        $query = FaqCategory::query()->where('locale', $locale);
        $query->orderBy('order_idx');
        $query->latest();

        $categories = $query->get();

        return view('admin.faq.category.list', compact('locale', 'categories'));
    }

    #[Post('category', 'admin.faq.category.store.order')]
    public function category_store_order(Request $request)
    {
        foreach ($request->category_ids as $idx => $category_id) {
            FaqCategory::where('id', $category_id)->update(['order_idx' => $idx]);
        }

        return to_route('admin.faq.category.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }

    #[Get('create', 'admin.faq.create')]
    #[Get('{faq}', 'admin.faq.detail')]
    public function detail(Request $request, ?Faq $faq = null)
    {
        $categories = $this->get_categories();

        return view('admin.faq.detail', compact('faq', 'categories'));
    }

    #[Post('create', 'admin.faq.store')]
    #[Post('{faq}', 'admin.faq.update')]
    public function store(FaqRequest $request, ?Faq $faq = null)
    {
        $request->handle($faq);

        if (is_null($faq)) {
            return to_route('admin.faq.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.faq.detail', array_merge($request->query(), compact('faq'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{faq}', 'admin.faq.delete')]
    public function delete(Request $request, Faq $faq)
    {
        $faq->delete();

        return to_route('admin.faq.list', array_merge($request->query(), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-03'));
    }

    #[Get('', 'admin.faq.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $search = $request->query('search');
        $searchType = $request->query('search_type', 'title');
        $filterCategory = intval($request->query('filter_category'));

        $query = Faq::query()->where('locale', $locale);

        if (! empty($search)) {
            $searchInput = '%' . str_replace(' ', '%', $search) . '%';

            if ('author' === $searchType) {
                $query->whereHas('author', function (Builder $query) use ($searchInput) {
                    $query->where(DB::raw('LOWER(name)'), 'LIKE', $searchInput);
                });
            } elseif (in_array($searchType, ['question', 'answer'])) {
                $query->where(DB::raw("LOWER({$searchType})"), 'LIKE', $searchInput);
            }
        }

        if ($filterCategory > 0) {
            $query->where('faq_category_id', $filterCategory);
        }

        $query->orderByDesc('published_at');
        $query->latest();

        $faqs = $query->paginate(10);
        $categories = $this->get_categories();

        return view('admin.faq.list', compact('locale', 'search', 'searchType', 'filterCategory', 'faqs', 'categories'));
    }

    private function get_categories()
    {
        return FaqCategory::where('locale', $this->get_admin_locale())->select('id', 'name')->orderBy('order_idx')->latest()->get();
    }
}
