<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('event')]
class EventController extends Controller
{
    #[Get('', 'admin.event.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $search = $request->query('search');
        $search_type = $request->query('search_type', 'title');
        $filter_progress = $request->query('filter_progress');

        $query = Event::query()->where('locale', $locale);

        if ('proceed' === $filter_progress) { // 진행예정
            $query->where('use_always', 0)->where('start_date', '>', now());
        } elseif ('proceeding' === $filter_progress) { // 진행중
            $query->where(function (Builder $query) {
                $query
                    ->where('use_always', 1)
                    ->orWhereBetweenColumns(DB::raw("'" . now() . "'"), ['start_date', 'end_date']);
            });
        } elseif ('ended' === $filter_progress) { // 종료
            $query->where('use_always', 0)->where('end_date', '<', now());
        }

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

        $events = $query->paginate(10);

        return view('admin.board.event.list', compact('locale', 'search', 'search_type', 'filter_progress', 'events'));
    }

    #[Get('create', 'admin.event.create')]
    #[Get('{event}', 'admin.event.detail')]
    public function detail(Request $request, ?Event $event = null)
    {
        return view('admin.board.event.detail', compact('event'));
    }

    #[Post('create', 'admin.event.store')]
    #[Post('{event}', 'admin.event.update')]
    public function store(EventRequest $request, ?Event $event = null)
    {
        $request->handle($event);

        if (is_null($event)) {
            return to_route('admin.event.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.event.detail', array_merge($request->query(), compact('event'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{event}', 'admin.event.delete')]
    public function delete(Request $request, Event $event)
    {
        $event->delete();

        return to_route('admin.event.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }
}
