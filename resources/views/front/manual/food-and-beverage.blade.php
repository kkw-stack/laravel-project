@extends('front.partials.layout', [
    'view' => 'manual-food-and-beverage',
    'seo_title' => __('front.fnb.title'),
    'seo_description' => __('front.desc.fnb'),
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--01">{!! __('front.fnb.title') !!}</h1>
            <p class="article__desc jt-typo--12">{!! __('front.fnb.desc') !!}</p>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    @include('front.partials.sub-visual', ['images' => [
        ['desktop' => '/assets/front/images/sub/manual-food-and-beverage-visual-01.jpg', 'mobile' => '/assets/front/images/sub/manual-food-and-beverage-visual-01-mobile.jpg']
    ]])

    <div class="article__body">

        <div class="article__section maunal-service-gallery">
            <div class="wrap">
                <div class="maunal-service-gallery__container">
                    <div class="maunal-service-gallery__sticky">
                        <div class="maunal-service-gallery__sticky-inner">
                            <h2 class="maunal-service-gallery__sticky-title jt-typo--03">{!! __('front.fnb.sticky.title') !!}</h2>

                            <div class="maunal-service-gallery__sticky-desc">
                                @foreach ( __('front.fnb.sticky.desc') as $desc )
                                    <p class="jt-typo--13">{!! $desc !!}</p>
                                @endforeach
                            </div><!-- .maunal-service-gallery__sticky-desc -->
                        </div><!-- .maunal-service-gallery__sticky -->
                    </div><!-- .maunal-service-gallery__sticky -->

                    <div class="maunal-service-gallery__content">
                        <div class="maunal-service-gallery__list">

                            <div class="maunal-service-gallery__item">
                                <div class="maunal-service-gallery__thumb">
                                    <figure class="jt-lazyload">
                                        <span class="jt-lazyload__color-preview"></span>
                                        <img width="732" height="800" data-unveil="/assets/front/images/sub/manual-food-and-beverage-gallery-01.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                                        <noscript><img src="/assets/front/images/sub/manual-food-and-beverage-gallery-01.jpg" alt="" /></noscript>
                                    </figure><!-- .jt-lazyload -->
                                </div><!-- .maunal-service-gallery__thumb -->
                            </div><!-- .maunal-service-gallery__item -->

                            <div class="maunal-service-gallery__item">
                                <div class="maunal-service-gallery__thumb">
                                    <figure class="jt-lazyload">
                                        <span class="jt-lazyload__color-preview"></span>
                                        <img width="732" height="800" data-unveil="/assets/front/images/sub/manual-food-and-beverage-gallery-02.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                                        <noscript><img src="/assets/front/images/sub/manual-food-and-beverage-gallery-02.jpg" alt="" /></noscript>
                                    </figure><!-- .jt-lazyload -->
                                </div><!-- .maunal-service-gallery__thumb -->
                            </div><!-- .maunal-service-gallery__item -->

                            <div class="maunal-service-gallery__item">
                                <div class="maunal-service-gallery__thumb">
                                    <figure class="jt-lazyload">
                                        <span class="jt-lazyload__color-preview"></span>
                                        <img width="732" height="800" data-unveil="/assets/front/images/sub/manual-food-and-beverage-gallery-03.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                                        <noscript><img src="/assets/front/images/sub/manual-food-and-beverage-gallery-03.jpg" alt="" /></noscript>
                                    </figure><!-- .jt-lazyload -->
                                </div><!-- .maunal-service-gallery__thumb -->
                            </div><!-- .maunal-service-gallery__item -->

                        </div><!-- .maunal-service-gallery__list -->
                    </div><!-- .maunal-service-gallery__content -->
                </div><!-- .maunal-service-gallery__container -->
            </div><!-- .wrap -->
        </div><!-- .maunal-service-gallery -->

    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
