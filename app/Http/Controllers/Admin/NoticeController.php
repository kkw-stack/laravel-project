<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NoticeRequest;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('notice')]
class NoticeController extends Controller
{
    #[Get('', 'admin.notice.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $search = $request->query('search');
        $search_type = $request->query('search_type', 'title');

        $query = Notice::query()->where('locale', $locale);

        if (! empty($search)) {
            if ('author' === $search_type) {
                $query->whereHas('author', function ($query) use ($search) {
                    $query->where(DB::raw('LOWER(name)'), 'like', '%' . str_replace(' ', '%', $search) . '%');
                });
            } elseif (in_array($search_type, ['title', 'content'])) {
                $query->where(DB::raw("LOWER({$search_type})"), 'like', '%' . str_replace(' ', '%', $search) . '%');
            }
        }

        $query->orderByDesc('is_notice');
        $query->orderByDesc('published_at');
        $query->latest();

        $notices = $query->paginate(10);

        return view('admin.board.notice.list', compact('locale', 'search', 'search_type', 'notices'));
    }

    #[Get('create', 'admin.notice.create')]
    #[Get('{notice}', 'admin.notice.detail')]
    public function detail(Request $request, ?Notice $notice = null)
    {
        return view('admin.board.notice.detail', compact('notice'));
    }

    #[Post('create', 'admin.notice.store')]
    #[Post('{notice}', 'admin.notice.update')]
    public function store(NoticeRequest $request, ?Notice $notice = null)
    {
        $request->handle($notice);

        if (is_null($notice)) {
            return to_route('admin.notice.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.notice.detail', array_merge($request->query(), compact('notice'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{notice}', 'admin.notice.delete')]
    public function delete(Request $request, Notice $notice)
    {
        $notice->delete();

        return to_route('admin.notice.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }
}
