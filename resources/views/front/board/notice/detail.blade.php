@extends('front.partials.layout', [
    'view' => 'board-notice-detail',
    'seo_title' => $notice->title,
    'seo_description' => $notice->content,
])

@section('content')
<div class="jt-single">
    <div class="jt-single__inner">
        <div class="jt-single__header">
            <ul class="jt-single__meta">
                @if($notice->is_notice)
                    <li><span class="jt-typo--15">( {!! __('front.notice.pinned') !!} )</span></li>
                @endif
                <li>
                    <span class="jt-typo--15"><time datetime="{{ $notice->published_at }}">{{ $notice->published_at->format('Y. m. d') }}</time></span>
                </li>
            </ul><!-- .jt-single__meta -->

            <div class="jt-single__title-wrap">
                <h1 class="jt-single__title jt-typo--02">{{ $notice->title }}</h1>

                <div class="jt-single__share">
                    @include('front.partials.share')
                </div><!-- .jt-single__share -->
            </div><!-- .jt-single__title-wrap -->
        </div><!-- .jt-single__header -->

        <div class="jt-single__body">

            <div class="jt-single__content">{!! content($notice->content) !!}</div>

            @include('front.board.partials.board-files', ['files' => $notice->files])

            <div class="jt-single__post">
                <div class="jt-single__post-item">
                    <div class="jt-single__post-subject">
                        <b class="jt-typo--12">{!! __('front.ui.prev-post') !!}</b>
                    </div><!-- .jt-single__post-subject -->

                    <div class="jt-single__post-data">
                        @if($prev = $notice->prev())
                            <a href="{{ jt_route('board.notice.detail', [...request()->query(), 'notice' => $prev])}}" class="jt-typo--15">{{ $prev->is_notice ? '( '.__('front.notice.pinned').' ) ' : ''}}{{ $prev->title }}</a>
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
                        @if($next = $notice->next())
                            <a href="{{ jt_route('board.notice.detail', [...request()->query(), 'notice' => $next])}}" class="jt-typo--15">{{ $next->is_notice ? '( '.__('front.notice.pinned').' ) ' : ''}}{{ $next->title }}</a>
                        @else
                            <span class="jt-typo--15">{!! __('front.ui.next-empty') !!}</span>
                        @endif
                    </div><!-- .jt-single__post-data -->
                </div><!-- .jt-single__post-item -->
            </div><!-- .jt-single__post -->

            <div class="jt-controls">
                <a href="{{ jt_route('board.notice.list', request()->query()) }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.go-list') !!}</span></a>
            </div><!-- .jt-controls -->

        </div><!-- .jt-single__body -->
    </div><!-- .jt-single__inner -->
</div><!-- .jt-single -->
@endsection
