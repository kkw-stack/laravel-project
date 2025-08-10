<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('news')]
class NewsController extends Controller
{
    #[Get('', 'admin.news.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $search = $request->query('search');
        $search_type = $request->query('search_type', 'title');
        $query = News::query()->where('locale', $locale);

        if (! empty($search)) {
            if ($search_type === 'author') {
                $query->whereHas('author', function ($query) use ($search) {
                    $query->where(DB::raw('LOWER(name)'), 'like', '%' . str_replace(' ', '%', $search) . '%');
                });
            } elseif (in_array($search_type, ['title', 'content'])) {
                $query->where($search_type, 'like', '%' . str_replace(' ', '%', $search) . '%');
            }
        }

        $query->orderByDesc('published_at');
        $query->latest();

        $newses = $query->paginate(10);

        return view('admin.board.news.list', compact('locale', 'search', 'search_type', 'newses'));
    }

    #[Get('create', 'admin.news.create')]
    #[Get('{news}', 'admin.news.detail')]
    public function detail(Request $request, ?News $news = null)
    {
        return view('admin.board.news.detail', compact('news'));
    }

    #[Post('create', 'admin.news.store')]
    #[Post('{news}', 'admin.news.update')]
    public function store(NewsRequest $request, ?News $news = null)
    {
        $request->handle($news);

        if (is_null($news)) {
            return to_route('admin.news.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.news.detail', array_merge($request->query(), compact('news'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{news}', 'admin.news.delete')]
    public function delete(Request $request, News $news)
    {
        $news->delete();

        return to_route('admin.news.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }
}
