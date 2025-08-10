@extends('front.partials.layout', [
    'view' => 'board-news-detail',
    'seo_title' => $news->title,
    'seo_description' => $news->content,
])

@section('content')
<div class="jt-single">
    <div class="jt-single__inner">
        <div class="jt-single__header">
            <ul class="jt-single__meta">
                <li>
                    <span class="jt-typo--15"><time datetime="{{ $news->published_at }}">{{ $news->published_at->format('Y. m. d') }}</time></span>
                </li>
            </ul><!-- .jt-single__meta -->

            <div class="jt-single__title-wrap">
                <h1 class="jt-single__title jt-typo--02">{{ $news->title }}</h1>

                <div class="jt-single__share">
                    @include('front.partials.share')
                </div><!-- .jt-single__share -->
            </div><!-- .jt-single__title-wrap -->
        </div><!-- .jt-single__header -->

        <div class="jt-single__body">
            <div class="jt-single__content">{!! content($news->content) !!}</div><!-- .jt-single__content -->

            <div class="jt-single__post">
                <div class="jt-single__post-item">
                    <div class="jt-single__post-subject">
                        <b class="jt-typo--12">{!! __('front.ui.prev-post') !!}</b>
                    </div><!-- .jt-single__post-subject -->

                    <div class="jt-single__post-data">
                        @if($prev = $news->prev())
                            <a href="{{ jt_route('board.news.detail', [...request()->query(), 'news' => $prev])}}" class="jt-typo--15">{{ $prev->title }}</a>
                        @else
                            <span class="jt-typo--15">{!! __('front.ui.prev-empty') !!}</span>
                        @endif
                    </div><!-- .jt-single__post-data -->
                </div><!-- .jt-single__post-item -->

                <div class="jt-single__post-item">
                    <div class="jt-single__post-subject">
                        <b class="jt-typo--12">{!! __('front.ui.next-post') !!}</b>
                    </div><!-- .jt-single__post-subject -->

                    <div class="jt-single__post-data">
                        @if($next = $news->next())
                            <a href="{{ jt_route('board.news.detail', [...request()->query(), 'news' => $next])}}" class="jt-typo--15">{{ $next->title }}</a>
                        @else
                            <span class="jt-typo--15">{!! __('front.ui.next-empty') !!}</span>
                        @endif
                    </div><!-- .jt-single__post-data -->
                </div><!-- .jt-single__post-item -->
            </div><!-- .jt-single__post -->

            <div class="jt-controls">
                <a href="{{ jt_route('board.news.list', request()->query()) }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.go-list') !!}</span></a>
            </div><!-- .jt-controls -->

        </div><!-- .jt-single__body -->
    </div><!-- .jt-single__inner -->
</div><!-- .jt-single -->
@endsection
