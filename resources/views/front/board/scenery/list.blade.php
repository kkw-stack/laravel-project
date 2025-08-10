@extends('front.partials.layout', [
    'view' => 'board-scenery-list',
    'seo_title' => __('front.scenery.title'),
    'seo_description' => __('front.desc.scenery'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--02">{!! __('front.scenery.title') !!}</h1>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    <div class="article__body">

        <div class="article__section article__section--primary">
            <div class="wrap">
                <div class="jt-category">
                    @foreach($categories as $category)
                        <a
                            href="{{ jt_route('board.scenery.list', ['cate' => $category->id]) }}"
                            @class([
                                'jt-category--current' =>
                                    ($scenery_category_id == $category->id) ||
                                    (empty($scenery_category_id) && $loop->first),
                            ])
                        >
                            <span class="jt-typo--10">{{ $category->name }}</span>
                        </a>
                    @endforeach
                </div><!-- .jt-category -->

                <div class="jt-category__content">
                    @if($board_list->count() > 0 )
                            <ul class="jt-board__scenery">
                                @foreach( $board_list as $scenery )
                                    <li>
                                        <a href="{{ Storage::url($scenery->thumbnail) }}" target="_blank" class="jt-board__scenery-popup">
                                            <div class="jt-board__scenery-thumb">
                                                <figure class="jt-lazyload">
                                                    <span class="jt-lazyload__color-preview"></span>
                                                    <img width="476" height="241" data-unveil="{{ Storage::url($scenery->thumbnail) }}" src="/assets/front/images/layout/blank.gif" alt="" />
                                                    <noscript><img src="{{ Storage::url($scenery->thumbnail) }}" alt="" /></noscript>
                                                </figure><!-- .jt-lazyload -->
                                            </div><!-- .jt-board__scenery-thumb -->

                                            <div class="jt-board__scenery-data">
                                                <h2 class="jt-board__scenery-title"><span class="jt-typo--08">{{ $scenery->title }}</span></h2>
                                            </div><!-- .jt-board__scenery-data -->
                                        </a>
                                    </li>
                                @endforeach
                            </ul><!-- .jt-board__scenery -->

                        {{ $board_list->withQueryString()->links('front.partials.pagination') }}
                    @else
                        @include('front.partials.empty')

                        <div class="jt-controls">
                            <a href="{{ jt_route('index') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.go-home') !!}</span></a>
                        </div><!-- .jt-btns -->
                    @endif
                </div><!-- .jt-category__content -->
            </div><!-- .wrap -->
        </div><!-- .board-event-list -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection



@push('popup')
    @if( $board_list->count() > 0 )
        <div class="jt-scenery-popup jt-popup">
            <div class="jt-popup__container">
                <div class="jt-popup__container-inner">
                    <div class="jt-scenery-popup__slider swiper">
                        <div class="swiper-wrapper">
                            
                        </div><!-- .swiper-wrapper -->
                        
                        <div class="swiper-controls">
                            <div class="swiper-button swiper-button-prev">
                                <i class="jt-icon">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M14.4,16.3,8.11,9.92l6.28-6.21A1,1,0,1,0,13,2.29L5.28,9.9,13,17.7a1,1,0,1,0,1.42-1.4Z"/>
                                    </svg>
                                </i><!-- .jt-icon -->
                                <span class="sr-only">{!! __('front.ui.prev') !!}</span>
                            </div><!-- .swiper-button-prev -->

                            <div class="swiper-button swiper-button-next">
                                <i class="jt-icon">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M8.4,17.7l7.71-7.8L8.39,2.29A1,1,0,0,0,7,3.71l6.29,6.21L7,16.3A1,1,0,0,0,8.4,17.7Z"/>
                                    </svg>
                                </i><!-- .jt-icon -->
                                <span class="sr-only">{!! __('front.ui.next') !!}</span>
                            </div><!-- .swiper-button-next -->
                        </div><!-- .swiper-controls -->
                    </div><!-- .main-scenery__slider -->

                    <button class="jt-popup__close">
                        <span class="sr-only">{!! __('front.ui.close-popup') !!}</span>
                        <i class="jt-icon">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M17.55 16.42L11.12 9.99L17.55 3.57L16.42 2.43L9.99 8.86L3.57 2.43L2.43 3.57L8.86 9.99L2.43 16.42L3.56 17.55L9.99 11.12L16.42 17.55L17.55 16.42z" />
                            </svg>
                        </i><!-- .jt-icon -->
                    </button><!-- .jt-popup__close -->
                </div><!-- .jt-popup__container-inner -->
            </div><!-- .jt-popup__container -->
        </div><!-- .jt-popup -->
    @endif
@endpush