@extends('front.partials.layout', [
    'view' => 'introduce-people',
    'seo_title' => __('front.people.title'),
    'seo_description' => __('front.desc.people'),
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--01">{!! __('front.people.title') !!}</h1>
            <p class="article__desc jt-typo--12">{!! __('front.people.desc') !!}</p>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    @include('front.partials.sub-visual', ['images' => [
        ['desktop' => '/assets/front/images/sub/introduce-people-visual-01.jpg', 'mobile' => '/assets/front/images/sub/introduce-people-visual-01-mobile.jpg'],
        ['desktop' => '/assets/front/images/sub/introduce-people-visual-02.jpg', 'mobile' => '/assets/front/images/sub/introduce-people-visual-02-mobile.jpg'],
        ['desktop' => '/assets/front/images/sub/introduce-people-visual-03.jpg', 'mobile' => '/assets/front/images/sub/introduce-people-visual-03-mobile.jpg'],
    ]])

    <div class="article__body">

        <div class="article__section introduce-people-gallery">
            <div class="wrap">
                <div class="introduce-people-gallery__head">
                    <div class="introduce-people-gallery__tab">
                        <a
                            href="#tab-00"
                            @class([
                                'jt-tab__btn',
                                'jt-tab--active' => empty(request()->query('tab', '00')) ? '' : 'jt-tab--active',
                            ])
                        >
                            <span class="jt-typo--10">{!! __('front.ui.all') !!}</span>
                        </a>

                        @foreach($categories as $category)
                            <a
                                href="#tab-0{{ $category->id }}"
                                @class([
                                    'jt-tab__btn',
                                    'jt-tab--active' => empty(request()->query('tab')) ? '' : 'jt-tab--active' ,
                                ])
                            >
                                <span class="jt-typo--10">{{ $category->title }}</span>
                            </a>
                        @endforeach
                    </div><!-- .introduce-people-gallery__tab -->
                </div><!-- .introduce-people-gallery__head -->

                <div class="introduce-people-gallery__content">
                    <div
                        id="tab-00"
                        @class([
                            'jt-tab__content',
                            'jt-tab--active', // => empty(request()->query('tab')) || request()->query('tab') == '00' ? 'jt-tab--active' : '',
                        ])
                    >
                        @include('front.introduce.partials.people-gallery-item', ['peoples' => $people])
                    </div><!-- .jt-tab__content -->

                    @foreach ($categories as $idx => $category)
                        <div
                            id="tab-0{{ $category->id }}"
                            @class([
                                'jt-tab__content',
                                // 'jt-tab--active' => $idx == 0,
                            ])
                        >
                            @include('front.introduce.partials.people-gallery-item', ['peoples' => $category->people])
                        </div><!-- .jt-tab__content -->
                    @endforeach
                </div><!-- .introduce-people-gallery__content -->
            </div><!-- .wrap -->
        </div><!-- .introduce-people-gallery -->

        <div class="article__section introduce-people-appeal">

            <div class="introduce-people-appeal__video">
                <div class="jt-background-video jt-autoplay-inview">
                    <div class="jt-background-video__vod">
                        <video playsinline loop muted>
                            <source src="https://player.vimeo.com/progressive_redirect/playback/970433783/rendition/1080p/file.mp4?loc=external&signature=f89060c215a791f7a6961187a4a0b870a1291a9b3ba99d0ea95169e80ecfce16" type="video/mp4" />
                        </video>
                    </div><!-- .jt-background-video__vod -->
                    <div class="jt-background-video__poster" data-unveil="/assets/front/images/sub/introduce-people-appeal-poster.jpg"></div>
                </div><!-- .jt-background-video -->
            </div><!-- .introduce-people-appeal__video -->

            <div class="introduce-people-appeal__content">
                <div class="wrap">
                    <p class="introduce-people-appeal__desc jt-typo--05">{!! __('front.people.appeal') !!}</p>
                </div><!-- .wrap -->
            </div><!-- .introduce-people-appeal__content -->

        </div><!-- .introduce-people-appeal -->

    </div><!-- .article__body -->
</div><!-- .article -->

@push('popup')
    <div class="introduce-people-popup jt-popup">
        <div class="jt-popup__container">

            <div class="jt-popup__container-inner">

            </div><!-- .jt-popup__container-inner -->

            <button class="jt-popup__close">
                <span class="sr-only">{!! __('front.ui.close-popup') !!}</span>
                <i class="jt-icon">
                    <svg width="52" height="52" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <path d="M47.23,45.8,27.43,26,47.22,6.21a1,1,0,0,0-1.41-1.42L26,24.59,6.22,4.79A1,1,0,0,0,4.81,6.21L24.6,26,4.8,45.8a1,1,0,0,0,1.41,1.42L26,27.41l19.8,19.81a1,1,0,0,0,.71.29,1,1,0,0,0,.7-1.71Z"></path>
                    </svg>
                </i><!-- .jt-icon -->
            </button><!-- .jt-popup__close -->
        </div><!-- .jt-popup__container -->
    </div><!-- .introduce-people-popup -->
@endpush

@endsection
