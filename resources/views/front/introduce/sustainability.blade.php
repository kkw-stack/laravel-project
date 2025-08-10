@extends('front.partials.layout', [
    'view' => 'introduce-sustainability',
    'seo_title' => __('front.sustainability.title'),
    'seo_description' => __('front.desc.sustainability'),
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--01">{!! __('front.sustainability.title') !!}</h1>
            <p class="article__desc jt-typo--12">{!! __('front.sustainability.desc') !!}</p>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    @include('front.partials.sub-visual', ['images' => [
        ['desktop' => '/assets/front/images/sub/introduce-sustainability-visual-01.jpg', 'mobile' => '/assets/front/images/sub/introduce-sustainability-visual-01.jpg'],
        ['desktop' => '/assets/front/images/sub/introduce-sustainability-visual-02.jpg', 'mobile' => '/assets/front/images/sub/introduce-sustainability-visual-02.jpg'],
        ['desktop' => '/assets/front/images/sub/introduce-sustainability-visual-03.jpg', 'mobile' => '/assets/front/images/sub/introduce-sustainability-visual-03.jpg']
    ]])

    <div class="article__body">

        <div class="article__section introduce-sustainability-vision">
            <div class="wrap-narrow">

                <div class="introduce-sustainability-vision__item">
                    <div class="introduce-sustainability-vision__content">
                        <h2 class="introduce-sustainability-vision__title jt-typo--03">{!! __('front.sustainability.vision')[0]['title'] !!}</h2>
                        <p class="introduce-sustainability-vision__desc jt-typo--13">{!! __('front.sustainability.vision')[0]['desc'] !!}</p>
                    </div><!-- .introduce-sustainability-vision__content -->

                    <div class="introduce-sustainability-vision__image">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="560" height="700" data-unveil="/assets/front/images/sub/introduce-sustainability-gardening.jpg?v1.1" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/introduce-sustainability-gardening.jpg?v1.1" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .introduce-sustainability-vision__image -->
                </div><!-- .introduce-sustainability-vision__item -->

                <div class="introduce-sustainability-vision__item">
                    <div class="introduce-sustainability-vision__content">
                        <h2 class="introduce-sustainability-vision__title jt-typo--03">{!! __('front.sustainability.vision')[1]['title'] !!}</h2>
                        <p class="introduce-sustainability-vision__desc jt-typo--13">{!! __('front.sustainability.vision')[1]['desc'] !!}</p>
                    </div><!-- .introduce-sustainability-vision__content -->

                    <div class="introduce-sustainability-vision__image">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="560" height="700" data-unveil="/assets/front/images/sub/introduce-sustainability-recycle.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/introduce-sustainability-recycle.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .introduce-sustainability-vision__image -->
                </div><!-- .introduce-sustainability-vision__item -->

            </div><!-- .wrap -->
        </div><!-- .introduce-sustainability-vision -->

    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
