@extends('front.partials.layout', [
    'view' => 'board-event-detail',
    'seo_title' => $event->title,
    'seo_description' => $event->content,
    'seo_image' => $event->thumbnail ? Storage::url($event->thumbnail) : '',
])

@section('content')
<div class="jt-single">
    <div class="jt-single__inner">
        <div class="jt-single__header">
            <div class="jt-single__title-wrap">
                <h1 class="jt-single__title jt-typo--02">{{ $event->title }}</h1>

                <div class="jt-single__share">
                    @include('front.partials.share')
                </div><!-- .jt-single__share -->
            </div><!-- .jt-single__title-wrap -->

            <ul class="jt-single__meta">
                <li>
                    <b class="jt-typo--12">{!! __('front.event.range') !!}</b>
                    <span class="jt-typo--13">{!! $event->use_always ? __('front.event.state.always') : '<time datetime="' . $event->start_date . '">' . $event->start_date->format('Y. m. d') . '</time>' . ' ~ ' . '<time datetime="' . $event->end_date . '">' . $event->end_date->format('Y. m. d') . '</time>' !!}</span>
                </li>

                @if($event->location)
                    <li>
                        <b class="jt-typo--12">{!! __('front.event.place') !!}</b>
                        <span class="jt-typo--13">{{ $event->location }}</span>
                    </li>
                @endif
            </ul><!-- .jt-single__meta -->
        </div><!-- .jt-single__header -->

        <div class="jt-single__body">
            <div class="jt-single__content">{!! content($event->content) !!}</div>

            @include('front.board.partials.board-files', ['files' => $event->files])

            <div class="jt-controls">
                <a href="{{ jt_route('board.event.list', request()->query()) }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.go-list') !!}</span></a>
            </div><!-- .jt-controls -->

        </div><!-- .jt-single__body -->
    </div><!-- .jt-single__inner -->

    @if($event->latest_items()->count() > 0)
        <div class="jt-single__last">
            <div class="wrap">
                <div class="jt-single__last-wrap">
                    <h2 class="jt-single__last-title jt-typo--04">{!! __('front.event.last') !!}</h2>

                    <div class="jt-single__last-inner">
                        <ul class="jt-board__grid">
                            @foreach($event->latest_items() as $item)
                                <li>
                                    <a href="{{ jt_route('board.event.detail', [...request()->query(), 'event' => $item]) }}">
                                        <div class="jt-board__grid-thumb">
                                            <figure class="jt-lazyload">
                                                <span class="jt-lazyload__color-preview"></span>
                                                <img width="348" height="348" data-unveil="{{ $item->thumbnail ? Storage::url($item->thumbnail) : '/assets/front/images/sub/board-grid-no-image.jpg' }}" src="/assets/front/images/layout/blank.gif" alt="" />
                                                <noscript><img src="{{ $item->thumbnail ? Storage::url($item->thumbnail) : '/assets/front/images/sub/board-grid-no-image.jpg' }}" alt="" /></noscript>
                                            </figure><!-- .jt-lazyload -->
                                        </div><!-- .jt-board__grid-thumb -->

                                        <div class="jt-board__grid-data">
                                            <h3 class="jt-board__grid-title"><span class="jt-typo--08">{{ $item->title }}</span></h3>
                                            @if( $item->use_always )
                                                <span class="jt-board__grid-date jt-typo--15">{!! __('front.event.state.always') !!}</span>
                                            @else
                                                <span class="jt-board__grid-date jt-typo--15">
                                                    <time datetime="{{ $item->start_date }}">{{ $item->start_date->format('Y. m. d') }}</time> ~ <time datetime="{{ $item->end_date }}">{{ $item->end_date->format('Y. m. d') }}</time>
                                                </span>
                                            @endif
                                        </div><!-- .jt-board__grid-data -->
                                    </a>
                                </li>
                            @endforeach
                        </ul><!-- .jt-board__grid -->
                    </div><!-- .jt-single__last-inner -->
                </div><!-- .jt-single__last-wrap -->
            </div><!-- .wrap -->
        </div><!-- .jt-single__last -->
    @endif
</div><!-- .jt-single -->
@endsection
