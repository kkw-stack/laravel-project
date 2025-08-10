<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\News;
use App\Models\Notice;
use App\Models\SceneryGallery;
use App\Models\SceneryGalleryCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class BoardController extends Controller
{
    #[Get('board/notice', 'ko.board.notice.list')]
    #[Get('en/board/notice', 'en.board.notice.list')]
    public function notice_list(Request $request)
    {
        $locale = $this->get_locale();
        $query = Notice::query()->where('locale', $locale);
        $query->where('status', true);
        $query->where('published_at', '<=', now());
        $query->orderByDesc('is_notice');
        $query->orderByDesc('published_at');
        $query->latest();

        $board_list = $query->paginate(10);
        return view('front.board.notice.list', [
            'board_list' => $board_list,
        ]);
    }

    #[Get('board/notice/{notice}', 'ko.board.notice.detail')]
    #[Get('en/board/notice/{notice}', 'en.board.notice.detail')]
    public function notice_detail(Request $request, Notice $notice)
    {
        if (! $notice->status || $notice->published_at > now() || $notice->locale !== $this->get_locale()) {
            abort(404);
        }

        return view('front.board.notice.detail', compact('notice'));
    }

    #[Get('board/news', 'ko.board.news.list')]
    #[Get('en/board/news', 'en.board.news.list')]
    public function news_list(Request $request)
    {
        $locale = $this->get_locale();
        $query = News::query()->where('locale', $locale);
        $query->where('status', true);
        $query->where('published_at', '<=', now());
        $query->orderByDesc('published_at');
        $query->latest();

        $board_list = $query->paginate(10);

        return view('front.board.news.list', [
            'board_list' => $board_list,
        ]);
    }

    #[Get('board/news/{news}', 'ko.board.news.detail')]
    #[Get('en/board/news/{news}', 'en.board.news.detail')]
    public function news_detail(Request $request, News $news)
    {
        if (! $news->status || $news->published_at > now() || $news->locale !== $this->get_locale()) {
            abort(404);
        }

        if ($news->use_link) {
            return redirect($news->link);
        }

        return view('front.board.news.detail', compact('news'));
    }

    #[Get('board/event', 'ko.board.event.list')]
    #[Get('en/board/event', 'en.board.event.list')]
    public function event_list(Request $request)
    {
        // 행사 페이지 숨김 처리
        if (! $this->is_dev()) {
            abort(404);
        }

        $locale = $this->get_locale();
        $filter_progress = $request?->filter_progress ?? 'proceeding';
        $sort = $request?->sort ?? 'start_date';

        $query = Event::query()->where('locale', $locale);

        $query->where('status', true);
        $query->where('published_at', '<=', now());

        if ('proceed' === $filter_progress) {
            $query->where('use_always', 0)->where('start_date', '>', now());
        } elseif ('ended' === $filter_progress) {
            $query->where('use_always', 0)->where('end_date', '<', now());
        } else {
            $query->where(function (Builder $query) {
                $query->where('use_always', 1)->orWhereRaw("? BETWEEN start_date AND end_date", [now()]);
            });
        }

        if ('published_at' === $sort) {
            $query->orderByDesc('published_at');
        } else if ('proceeding' === $filter_progress && 'start_date' === $sort) {
            $query->orderByRaw(
                '
                use_always ASC
                , CASE WHEN start_date >= ? THEN 0 ELSE 1 END
                , ABS(TIMESTAMPDIFF(SECOND, start_date, ?))
                , published_at DESC
                ',
                [now(), now()]
            );
        } else {
            $query->orderByRaw(
                '
                use_always DESC
                , CASE WHEN start_date >= ? THEN 0 ELSE 1 END
                , ABS(TIMESTAMPDIFF(SECOND, start_date, ?))
                , published_at DESC
                ',
                [now(), now()]
            );
        }

        $query->latest();

        $board_list = $query->paginate(12);

        return view('front.board.event.list', compact('filter_progress', 'sort', 'board_list'));
    }

    #[Get('board/event/{event}', 'ko.board.event.detail')]
    #[Get('en/board/event/{event}', 'en.board.event.detail')]
    public function event_detail(Request $request, Event $event)
    {
        // 행사 페이지 숨김 처리
        if (! $this->is_dev()) {
            abort(404);
        }

        if (! $event->status || $event->published_at > now() || $event->locale !== $this->get_locale()) {
            abort(404);
        }

        return view('front.board.event.detail', compact('event'));
    }

    #[Get('board/scenery', 'ko.board.scenery.list')]
    #[Get('en/board/scenery', 'en.board.scenery.list')]
    public function scenery_list(Request $request)
    {
        $locale = $this->get_locale();
        
        $categories = SceneryGalleryCategory::where('locale', $locale)
            ->orderBy('order_idx')
            ->latest()
            ->get();
    
        $scenery_category_id = $request->input('cate') ?: $categories->first()?->id;
    
        $board_list = SceneryGallery::query()
            ->where('locale', $locale)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->when($scenery_category_id, fn($q) => $q->where('scenery_category_id', $scenery_category_id))
            ->orderByDesc('published_at')
            ->paginate(12);
    
        return view('front.board.scenery.list', compact(
            'board_list', 'categories', 'scenery_category_id'
        ));
    }    
}
