<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MainFeedRequest;
use App\Models\Event;
use App\Models\MainFeed;
use App\Models\News;
use App\Models\Notice;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('main/feed')]
class MainFeedController extends Controller
{
    #[Get('', 'admin.main.feed.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();

        $notices = Notice::select('id', 'title')->where('locale', $locale)->where('status', true)->where('published_at', '<=', now())->orderByDesc('published_at')->latest()->get();
        $newses = News::select('id', 'title')->where('locale', $locale)->where('status', true)->where('published_at', '<=', now())->orderByDesc('published_at')->latest()->get();
        $events = Event::select('id', 'title')->where('locale', $locale)->where('status', true)->where('published_at', '<=', now())->orderByDesc('published_at')->latest()->get();

        $feeds = MainFeed::adminItems($locale);

        return view('admin.main.feed.list', compact('locale', 'feeds', 'notices', 'newses', 'events'));
    }

    #[Post('', 'admin.main.feed.store')]
    public function store(MainFeedRequest $request)
    {
        $request->handle();

        return to_route('admin.main.feed.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }
}
