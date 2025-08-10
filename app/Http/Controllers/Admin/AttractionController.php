<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttractionRequest;
use App\Models\Attraction;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('intro/attractions')]
class AttractionController extends Controller
{
    #[Get('', 'admin.intro.attractions.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $query = Attraction::query()->where('locale', $locale);
        $query->orderBy('order_idx')->orderByDesc('published_at')->latest();

        $attractions = $query->get();

        return view('admin.intro.attractions.list', compact('locale', 'attractions'));
    }

    #[Post('', 'admin.intro.attractions.store.order')]
    public function store_order(Request $request)
    {
        foreach ($request->sort_ids as $idx => $attraction_id) {
            Attraction::where('id', $attraction_id)->update(['order_idx' => $idx]);
        }

        return to_route('admin.intro.attractions.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }

    #[Get('create', 'admin.intro.attractions.create')]
    #[Get('{attraction}', 'admin.intro.attractions.detail')]
    public function detail(Request $request, ?Attraction $attraction = null)
    {
        return view('admin.intro.attractions.detail', compact('attraction'));
    }

    #[Post('create', 'admin.intro.attractions.store')]
    #[Post('{attraction}', 'admin.intro.attractions.update')]
    public function store(AttractionRequest $request, ?Attraction $attraction = null)
    {
        $request->handle($attraction);

        if (is_null($attraction)) {
            return to_route('admin.intro.attractions.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.intro.attractions.detail', array_merge($request->query(), compact('attraction'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{attraction}', 'admin.intro.attractions.delete')]
    public function delete(Request $request, Attraction $attraction)
    {
        $attraction->delete();

        return to_route('admin.intro.attractions.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }
}
