@extends('front.partials.layout', [
    'view' => 'board-news-list',
    'seo_title' => __('front.news.title'),
    'seo_description' => __('front.desc.news'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--02">{!! __('front.news.title') !!}</h1>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    <div class="article__body">

        <div class="article__section article__section--primary board-notice-list">
            <div class="wrap-narrow">
                @if($board_list->count() > 0)
                    <ul class="jt-board__list">
                        @foreach($board_list as $idx => $news)
                        <li>
                            <a href="{{ $news->use_link ? $news->link : jt_route('board.news.detail', [...request()->query(), 'news' => $news]) }}" {!! $news->use_link ? 'target="_blank" rel="noopener"' : '' !!}>
                                <span class="jt-board__list-state jt-board__list-number jt-typo--09">{{ $board_list->total() - (($board_list->currentPage() - 1) * $board_list->perPage()) - $idx }}</span>

                                <h2 class="jt-board__list-title">
                                    <span class="jt-typo--09">{{ $news->title }}</span>

                                    @if($news->use_link)
                                        <i class="jt-icon">
                                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                                <path d="M12.71,3.29A1.05,1.05,0,0,0,12,3H5.14a1,1,0,0,0,0,2H9.58L3.29,11.29a1,1,0,0,0,1.42,1.42L11,6.41v4.45a1,1,0,0,0,2,0V4A1.05,1.05,0,0,0,12.71,3.29Z"/>
                                            </svg>
                                        </i>
                                    @endif
                                </h2><!-- .jt-board__list-title -->

                                <time class="jt-board__list-date jt-typo--12" datetime="{{ $news->published_at }}">{{ $news->published_at->format('Y. m. d') }}</time>
                            </a>
                        </li>
                        @endforeach
                    </ul><!-- .jt-board__list -->

                    {{ $board_list->withQueryString()->links('front.partials.pagination') }}
                @else
                    @include('front.partials.empty')

                    <div class="jt-controls">
                        <a href="{{ jt_route('index') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.go-home') !!}</span></a>
                    </div><!-- .jt-btns -->
                @endif
            </div><!-- .wrap-narrow -->
        </div><!-- .board-notice-list -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection
