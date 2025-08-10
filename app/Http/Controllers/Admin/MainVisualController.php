<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MainVisualRequest;
use App\Models\MainVisual;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('main/visual')]
class MainVisualController extends Controller
{
    #[Get('', 'admin.main.visual.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();

        $mainVisuals = MainVisual::where('locale', $locale)->latest()->paginate(10);
        $sortVisuals = MainVisual::where('locale', $locale)->where('status', true)->orderByDesc('order_idx')->latest()->get();

        return view('admin.main.visual.list', compact('locale', 'mainVisuals', 'sortVisuals'));
    }

    #[Post('', 'admin.main.visual.store.order')]
    public function store_order(Request $request)
    {
        foreach ($request->sort_ids as $idx => $visualId) {
            MainVisual::where('id', $visualId)->update(['order_idx' => count($request->sort_ids) - $idx]);
        }

        return to_route('admin.main.visual.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }

    #[Get('create', 'admin.main.visual.create')]
    #[Get('{visual}', 'admin.main.visual.detail')]

    public function detail(Request $request, ?MainVisual $visual = null)
    {
        return view('admin.main.visual.detail', compact('visual'));
    }

    #[Post('create', 'admin.main.visual.store')]
    #[Post('{visual}', 'admin.main.visual.update')]
    public function store(MainVisualRequest $request, ?MainVisual $visual = null)
    {
        $request->handle($visual);

        if (is_null($visual)) {
            return to_route('admin.main.visual.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.main.visual.detail', array_merge($request->query(), compact('visual'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{visual}', 'admin.main.visual.delete')]
    public function delete(Request $request, MainVisual $visual)
    {
        if (! $visual->status || MainVisual::where('status', true)->where('id', '<>', $visual->id)->count() > 0) {
            $visual->delete();

            return to_route('admin.main.visual.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
        } else {
            return back()->with('error-message', __('jt.IN-50'));
        }
    }
}
