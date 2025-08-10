@extends('front.partials.layout', [
    'view' => 'board-event-list',
    'seo_title' => __('front.event.title'),
    'seo_description' => __('front.desc.event'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--01">{!! __('front.event.title') !!}</h1>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    <div class="article__body">

        <div class="article__section article__section--primary board-event-list">
            <div class="wrap">
                <div class="jt-search">
                    <div class="jt-filter">
                        <div class="jt-category">
                            <a
                                href="{{ jt_route('board.event.list', ['filter_progress' => 'proceeding', 'sort' => $sort]) }}"
                                @class([
                                    'jt-category--current' => 'proceeding' === $filter_progress,
                                ])
                            ><span class="jt-typo--10">{!! __('front.event.state.proceeding') !!}</span></a>
                            <a
                                href="{{ jt_route('board.event.list', ['filter_progress' => 'proceed', 'sort' => $sort]) }}"
                                @class([
                                    'jt-category--current' => 'proceed' === $filter_progress,
                                ])
                            ><span class="jt-typo--10">{!! __('front.event.state.proceed') !!}</span></a>
                            <a
                                href="{{ jt_route('board.event.list', ['filter_progress' => 'ended', 'sort' => $sort]) }}"
                                @class([
                                    'jt-category--current' => 'ended' === $filter_progress,
                                ])
                            ><span class="jt-typo--10">{!! __('front.event.state.ended') !!}</span></a>
                        </div><!-- .jt-category -->

                        <div class="jt-filter__sort">
                            <div class="jt-choices__wrap">
                                <select class="jt-choices">
                                    <option value="{{ jt_route('board.event.list', ['filter_progress' => $filter_progress, 'sort' => 'start_date']) }}">{!! __('front.event.order.startdate') !!}</option>
                                    <option value="{{ jt_route('board.event.list', ['filter_progress' => $filter_progress, 'sort' => 'published_at']) }}" @selected('published_at' === $sort)>{!! __('front.event.order.published') !!}</option>
                                </select><!-- .jt-choices -->
                            </div><!-- .jt-choices__wrap -->
                        </div><!-- .jt-filter__sort -->
                    </div><!-- .jt-filter -->
                </div><!-- .jt-search -->

                @if($board_list->count() > 0 )
                    <ul class="jt-board__grid">
                        @foreach( $board_list as $event )
                            <li>
                                <a href="{{ jt_route('board.event.detail', [...request()->query(), ...compact('event')]) }}">
                                    <div class="jt-board__grid-thumb">
                                        <figure class="jt-lazyload">
                                            <span class="jt-lazyload__color-preview"></span>
                                            <img width="476" height="476" data-unveil="{{ $event->thumbnail ? Storage::url($event->thumbnail) : '/assets/front/images/sub/board-grid-no-image.jpg' }}" src="/assets/front/images/layout/blank.gif" alt="" />
                                            <noscript><img src="{{ $event->thumbnail ? Storage::url($event->thumbnail) : '/assets/front/images/sub/board-grid-no-image.jpg' }}" alt="" /></noscript>
                                        </figure><!-- .jt-lazyload -->
                                    </div><!-- .jt-board__grid-thumb -->

                                    <div class="jt-board__grid-data">
                                        <h2 class="jt-board__grid-title"><span class="jt-typo--06">{{ $event->title }}</span></h2>

                                        @if( $event->use_always )
                                            <span class="jt-board__grid-date jt-typo--13">{!! __('front.event.state.always') !!}</span>
                                        @else
                                            <span class="jt-board__grid-date jt-typo--13">
                                                <time datetime="{{ $event->start_date }}">{{ $event->start_date->format('Y. m. d') }}</time> ~ <time datetime="{{ $event->end_date }}">{{ $event->end_date->format('Y. m. d') }}</time>
                                            </span>
                                        @endif
                                    </div><!-- .jt-board__grid-data -->
                                </a>
                            </li>
                        @endforeach
                    </ul><!-- .jt-board__grid -->

                    {{ $board_list->withQueryString()->links('front.partials.pagination') }}
                @else
                    @include('front.partials.empty')

                    <div class="jt-controls">
                        <a href="{{ jt_route('index') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.go-home') !!}</span></a>
                    </div><!-- .jt-btns -->
                @endif
            </div><!-- .wrap -->
        </div><!-- .board-event-list -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection
