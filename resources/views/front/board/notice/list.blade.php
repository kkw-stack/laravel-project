@extends('front.partials.layout', [
    'view' => 'board-notice-list',
    'seo_title' => __('front.notice.title.short'),
    'seo_description' => __('front.desc.notice'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--02">{!! __('front.notice.title.long') !!}</h1>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary board-notice-list">
            <div class="wrap-narrow">
                @if($board_list->count() > 0)
                    <ul class="jt-board__list">
                        @foreach($board_list as $idx => $notice)
                            <li>
                                <a href="{{ jt_route('board.notice.detail', [...request()->query(), ...compact('notice')]) }}">
                                    <span
                                        @class([
                                            'jt-board__list-state',
                                            'jt-typo--09',
                                            'jt-board__list-number' => !$notice->is_notice,
                                        ])
                                    >{{ $notice->is_notice ? '( '.__('front.notice.pinned').' )' : $board_list->total() - (($board_list->currentPage() - 1) * $board_list->perPage()) - $idx }}</span>
                                    <h2 class="jt-board__list-title">
                                        <span class="jt-typo--09">{{ $notice->title }}</span>
                                    </h2><!-- .jt-board__list-title -->
                                    <time class="jt-board__list-date jt-typo--12" datetime="{{ $notice->published_at }}">{{ $notice->published_at->format('Y. m. d') }}</time>
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
