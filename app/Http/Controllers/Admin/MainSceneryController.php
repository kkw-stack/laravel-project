<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MainSceneryRequest;
use App\Models\SceneryGallery;
use App\Models\MainScenery;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('main/scenery')]
class MainSceneryController extends Controller
{
    #[Get('', 'admin.main.scenery.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();

        $sceneryGallery = SceneryGallery::select('id', 'title')->where('locale', $locale)->where('status', true)->where('published_at', '<=', now())->orderByDesc('published_at')->latest()->get();
        $sceneriesSlide = MainScenery::adminItems($locale);

        return view('admin.main.scenery.list', compact('locale', 'sceneriesSlide', 'sceneryGallery'));
    }

    #[Post('', 'admin.main.scenery.store')]
    public function store(MainSceneryRequest $request)
    {
        $request->handle();

        return to_route('admin.main.scenery.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }
}
