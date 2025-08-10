@extends('front.partials.layout', [
    'view' => 'garden-korea',
    'seo_title' => __('front.garden-korea.title'),
    'seo_description' => __('front.desc.garden-korea'),
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--01">{!! __('front.garden-korea.title') !!}</h1>
            <p class="article__desc jt-typo--12">{!! __('front.garden-korea.desc') !!}</p>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    @include('front.partials.sub-visual', ['images' => [
        ['desktop' => '/assets/front/images/sub/garden-korea-visual-01.jpg', 'mobile' => '/assets/front/images/sub/garden-korea-visual-01-mobile.jpg'],
        ['desktop' => '/assets/front/images/sub/garden-korea-visual-02.jpg', 'mobile' => '/assets/front/images/sub/garden-korea-visual-02-mobile.jpg'],
        ['desktop' => '/assets/front/images/sub/garden-korea-visual-03.jpg', 'mobile' => '/assets/front/images/sub/garden-korea-visual-03-mobile.jpg'],
        ['desktop' => '/assets/front/images/sub/garden-korea-visual-04.jpg', 'mobile' => '/assets/front/images/sub/garden-korea-visual-04-mobile.jpg']
    ]])

    <div class="article__body">
        <div class="article__section garden-korea-motion">
            <div class="garden-korea-motion__sticky">
                <div class="garden-korea-motion__background garden-korea-motion__background--desktop">
                    <div class="jt-background-video jt-autoplay-inview">
                        <div class="jt-background-video__vod">
                            <video playsinline loop muted>
                                <source src="/assets/front/video/sub/bird.mp4" type="video/mp4" />
                            </video>
                        </div><!-- .jt-background-video__vod -->
                    </div><!-- .jt-background-video -->
                </div><!-- .garden-korea-motion__background -->

                <div class="garden-korea-motion__background garden-korea-motion__background--mobile">
                    <div class="jt-background-video jt-autoplay-inview">
                        <div class="jt-background-video__vod">
                            <video playsinline loop muted>
                                <source src="/assets/front/video/sub/bird-mobile.mp4" type="video/mp4" />
                            </video>
                        </div><!-- .jt-background-video__vod -->
                    </div><!-- .jt-background-video -->
                </div><!-- .garden-korea-motion__background -->

                <div class="wrap">
                    <h2 class="article__section-title jt-typo--03">{!! __('front.garden-korea.intro.title') !!}</h2>
                    <div class="article__section-desc">
                        <p class="jt-typo--12">{!! __('front.garden-korea.intro.desc') !!}</p>
                    </div><!-- .article__section-desc -->
                </div><!-- .wrap -->
            </div><!-- .garden-korea-motion__sticky -->

            <div class="garden-korea-motion__gallery">

                <div class="garden-korea-motion__item garden-korea-motion__item--01">
                    <div class="garden-korea-motion__image">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="604" height="755" data-unveil="/assets/front/images/sub/garden-korea-motion-01.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/garden-korea-motion-01.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .garden-korea-motion__image -->
                </div><!-- .garden-korea-motion__item -->

                <div class="garden-korea-motion__item garden-korea-motion__item--02">
                    <div class="garden-korea-motion__image">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="604" height="755" data-unveil="/assets/front/images/sub/garden-korea-motion-02.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/garden-korea-motion-02.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .garden-korea-motion__image -->
                </div><!-- .garden-korea-motion__item -->

                <div class="garden-korea-motion__item garden-korea-motion__item--03">
                    <div class="garden-korea-motion__image">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="963" height="628" data-unveil="/assets/front/images/sub/garden-korea-motion-03.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/garden-korea-motion-03.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .garden-korea-motion__image -->
                </div><!-- .garden-korea-motion__item -->

                <div class="garden-korea-motion__item garden-korea-motion__item--04">
                    <div class="garden-korea-motion__image">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="476" height="476" data-unveil="/assets/front/images/sub/garden-korea-motion-04.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/garden-korea-motion-04.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .garden-korea-motion__image -->
                </div><!-- .garden-korea-motion__item -->

            </div><!-- .garden-korea-motion__gallery -->

        </div><!-- .garden-korea-motion -->

        @if($categories->count() > 0)
            <div class="article__section garden-korea-gallery">
                <div class="garden-korea-gallery__head">
                    <div class="wrap">
                        <div class="garden-korea-gallery__tab">
                            @foreach($categories as $idx => $category)
                                <a
                                    href="#tab-{{ $category->id }}"
                                    @class([
                                        'jt-tab__btn',
                                        'jt-tab--active' => $idx == 0,
                                    ])
                                >
                                    <span class="jt-typo--05">{{ $category->title }}</span>
                                </a>
                            @endforeach
                        </div><!-- .garden-korea-gallery__tab -->
                    </div><!-- .wrap -->
                </div><!-- .garden-korea-gallery__head -->

                <div class="garden-korea-gallery__content">
                    @foreach ($categories as $idx => $category)
                        <div
                            id="tab-{{ $category->id }}"
                            @class([
                                'jt-tab__content',
                                'jt-tab--active' => $idx == 0,
                            ])
                        >
                            <div class="wrap">
                                <p class="garden-korea-gallery__desc jt-typo--13">{!! nl2br(e($category->content)) !!}</p>
                            </div><!-- .wrap -->

                            <div class="garden-korea-gallery__slider swiper">
                                <div class="swiper-wrapper">
                                    @foreach($category->koreaGardens as $garden)
                                        <div class="garden-korea-gallery__slide swiper-slide">
                                            @if(!empty($garden->video))
                                                <div class="garden-korea-gallery__video garden-korea-gallery__video--desktop">
                                                    <div class="jt-background-video">
                                                        <div class="jt-background-video__vod">
                                                            <video playsinline muted preload loop>
                                                                <source src="{{ $garden->video }}" type="video/mp4" />
                                                            </video>
                                                        </div><!-- .jt-background-video__vod -->
                                                        <div class="jt-background-video__poster swiper-lazy" data-background="{{ Storage::url($garden->image) }}" style="background-image: url(/assets/front/images/layout/blank.gif);">
                                                            <div class="jt-background-video__error">
                                                                <i class="jt-icon">
                                                                    <svg width="72" height="72" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M54.7808 38.674C56.4908 37.534 56.4908 35.0214 54.7808 33.8814L24.6374 13.7858C22.7235 12.5099 20.1599 13.8819 20.1599 16.1821V56.3733C20.1599 58.6735 22.7235 60.0456 24.6374 58.7696L54.7808 38.674Z" />
                                                                    </svg>
                                                                </i><!-- .jt-icon -->
                                                            </div><!-- .jt-background-video__error -->
                                                        </div><!-- .jt-background-video__poster -->
                                                    </div><!-- .jt-background-video -->
                                                </div><!-- .garden-korea-gallery__video -->
                                            @else
                                                <div
                                                    class="garden-korea-gallery__image garden-korea-gallery__image--desktop swiper-lazy"
                                                    data-background="{{ Storage::url($garden->image) }}"
                                                    style="background-image: url(/assets/front/images/layout/blank.gif);"
                                                ></div>
                                            @endif

                                            @if(!empty($garden->video_mobile))
                                                <div class="garden-korea-gallery__video garden-korea-gallery__video--mobile">
                                                    <div class="jt-background-video">
                                                        <div class="jt-background-video__vod">
                                                            <video playsinline muted preload loop>
                                                                <source src="{{ $garden->video_mobile }}" type="video/mp4" />
                                                            </video>
                                                        </div><!-- .jt-background-video__vod -->
                                                        <div class="jt-background-video__poster swiper-lazy" data-background="{{ Storage::url($garden?->image_mobile ?? $garden->image) }}" style="background-image: url(/assets/front/images/layout/blank.gif);">
                                                            <div class="jt-background-video__error">
                                                                <i class="jt-icon">
                                                                    <svg width="72" height="72" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M54.7808 38.674C56.4908 37.534 56.4908 35.0214 54.7808 33.8814L24.6374 13.7858C22.7235 12.5099 20.1599 13.8819 20.1599 16.1821V56.3733C20.1599 58.6735 22.7235 60.0456 24.6374 58.7696L54.7808 38.674Z" />
                                                                    </svg>
                                                                </i><!-- .jt-icon -->
                                                            </div><!-- .jt-background-video__error -->
                                                        </div><!-- .jt-background-video__poster -->
                                                    </div><!-- .jt-background-video -->
                                                </div><!-- .garden-korea-gallery__video -->
                                            @else
                                                <div
                                                    class="garden-korea-gallery__image garden-korea-gallery__image--mobile swiper-lazy"
                                                    data-background="{{ Storage::url($garden?->image_mobile ?? $garden->image) }}"
                                                    style="background-image: url(/assets/front/images/layout/blank.gif);"
                                                ></div>
                                            @endif

                                            <div class="garden-korea-gallery__data">
                                                <b class="jt-typo--09">{{ $garden->title }}</b>
                                                <p class="jt-typo--15">{!! nl2br(e($garden->content)) !!}</p>
                                            </div><!-- .garden-korea-gallery__data -->
                                        </div><!-- .garden-korea-gallery__slide -->
                                    @endforeach
                                </div><!-- .swiper-wrapper -->

                                <div class="swiper-button swiper-button-prev">
                                    <i class="jt-icon">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M14.4,16.3,8.11,9.92l6.28-6.21A1,1,0,1,0,13,2.29L5.28,9.9,13,17.7a1,1,0,1,0,1.42-1.4Z"/>
                                        </svg>
                                    </i><!-- .jt-icon -->
                                    <span class="sr-only">이전</span>
                                </div><!-- .swiper-button -->

                                <div class="swiper-button swiper-button-next">
                                    <i class="jt-icon">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M8.4,17.7l7.71-7.8L8.39,2.29A1,1,0,0,0,7,3.71l6.29,6.21L7,16.3A1,1,0,0,0,8.4,17.7Z"/>
                                        </svg>
                                    </i><!-- .jt-icon -->
                                    <span class="sr-only">다음</span>
                                </div><!-- .swiper-button -->
                            </div><!-- .garden-korea-gallery__slider -->
                        </div><!-- .jt-tab__content -->
                    @endforeach
                </div><!-- .garden-korea-gallery__content -->
            </div><!-- .garden-korea-gallery -->
        @endif

        {{-- @if(!empty($events))
            <div class="article__section garden-korea-notice">
                <div class="wrap">
                    <h2 class="article__section-title jt-typo--03">{!! __('front.garden-korea.notice.title') !!}</h2>

                    <ul class="jt-board__list">
                        @foreach($events as $event)
                            <li>
                                <a href="{{ jt_route('board.event.detail', compact('event')) }}">
                                    <span class="jt-board__list-state jt-typo--09">( {{ $event->currentStatusGardenLabel() }} )</span>
                                    <h3 class="jt-board__list-title">
                                        <span class="jt-typo--09">{{ $event->title }}</span>
                                    </h3><!-- .jt-board__list-title -->
                                    <time class="jt-board__list-date jt-typo--12" datetime="{{ $event->published_at }}">{{ $event->published_at->format('Y. m. d') }}</time>
                                </a>
                            </li>
                        @endforeach
                    </ul><!-- .jt-board__list -->

                    <div class="jt-board__more">
                        <a href="{{ jt_route('board.event.list') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">더 많은 소식 보기</span></a>
                    </div><!-- .jt-board__more -->
                </div><!-- .wrap -->
            </div><!-- .garden-korea-notice -->
        @endif --}}
    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
