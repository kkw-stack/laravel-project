<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VisitorGuideRequest;
use App\Models\VisitorGuide;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('guide/visitor')]
class VisitorGuideController extends Controller
{
    #[Get('', 'admin.guide.visitor.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $query = VisitorGuide::query()->where('locale', $locale);
        $query->where('revision_id', 0);

        $query->orderBy('order_idx')->latest();

        $guides = $query->get();
        return view('admin.guide.visitor.list', compact('locale', 'guides'));
    }

    #[Post('', 'admin.guide.visitor.store.order')]
    public function store_order(Request $request)
    {
        foreach ($request->sort_ids as $idx => $guide_id) {
            VisitorGuide::where('id', $guide_id)->update(['order_idx' => $idx]);
        }

        return to_route('admin.guide.visitor.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }

    #[Get('create', 'admin.guide.visitor.create')]
    #[Get('{guide}', 'admin.guide.visitor.detail')]
    public function detail(Request $request, ?VisitorGuide $guide = null)
    {
        return view('admin.guide.visitor.detail', compact('guide'));
    }

    #[Post('create', 'admin.guide.visitor.store')]
    #[Post('{guide}', 'admin.guide.visitor.update')]
    public function store(VisitorGuideRequest $request, ?VisitorGuide $guide = null)
    {
        $request->handle($guide);

        if (is_null($guide)) {
            return to_route('admin.guide.visitor.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        }

        return to_route('admin.guide.visitor.detail', array_merge($request->query(), compact('guide'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
    }

    #[Delete('{guide}', 'admin.guide.visitor.delete')]
    public function delete(Request $request, VisitorGuide $guide)
    {
        if (! $guide->status || VisitorGuide::where('revision_id', 0)->where('status', true)->where('published_at', '<=', now())->where('id', '<>', $guide->id)->count() > 0) {
            $guide->delete();

            return to_route('admin.guide.visitor.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
        } else {
            return back()->with('error-message', __('jt.IN-50'));
        }
    }
}
