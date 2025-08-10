@extends('front.partials.layout', [
    'view' => 'introduce-local-attractions',
    'seo_title' => __('front.local-attractions.title'),
    'seo_description' => __('front.desc.local-attractions'),
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--01">{!! __('front.local-attractions.title') !!}</h1>
            <p class="article__desc jt-typo--12">{!! __('front.local-attractions.desc') !!}</p>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    @include('front.partials.sub-visual', ['images' => [
        ['desktop' => '/assets/front/images/sub/introduce-local-attractions-visual-01.jpg', 'mobile' => '/assets/front/images/sub/introduce-local-attractions-visual-01.jpg']
    ]])

    <div class="article__body">

        <div class="article__section introduce-local-attractions-lounge">
            <div class="wrap">
                <div class="introduce-local-attractions-lounge__container">
                    <div class="introduce-local-attractions-lounge__sticky">
                        <div class="introduce-local-attractions-lounge__sticky-inner">
                            <h2 class="jt-typo--03">{!! __('front.local-attractions.sticky.title') !!}</h2>
                        </div><!-- .introduce-local-attractions-lounge__sticky -->
                    </div><!-- .introduce-local-attractions-lounge__sticky -->

                    <div class="introduce-local-attractions-lounge__content">
                        <ul class="introduce-local-attractions-lounge__list">
                            @foreach($attractions as $attraction)
                                <li>
                                    <div class="introduce-local-attractions-lounge__thumb">
                                        <figure class="jt-lazyload">
                                            <span class="jt-lazyload__color-preview"></span>
                                            <img width="732" height="500" data-unveil="{{ Storage::url($attraction->thumbnail) }}" src="/assets/front/images/layout/blank.gif" alt="" />
                                            <noscript><img src="{{ Storage::url($attraction->thumbnail) }}" alt="" /></noscript>
                                        </figure><!-- .jt-lazyload -->
                                    </div><!-- .introduce-local-attractions-lounge__thumb -->

                                    <div class="introduce-local-attractions-lounge__data">
                                        <div class="introduce-local-attractions-lounge__title">
                                            <h3 class="jt-typo--06">{{ $attraction->title }}</h3>

                                            <div class="introduce-local-attractions-lounge__distance">
                                                <i class="jt-icon">
                                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path d="M10,1A7,7,0,0,0,3,8a10.45,10.45,0,0,0,1.79,5.21c1,1.69,2.29,3.35,3.45,4.93h0a2.2,2.2,0,0,0,3.53,0h0a59.09,59.09,0,0,0,3.46-4.93A10.52,10.52,0,0,0,17,8,7,7,0,0,0,10,1Zm3.51,11.17a57.77,57.77,0,0,1-3.34,4.75L10,17l-.15-.07h0C8.67,15.32,7.43,13.7,6.5,12.16A8.69,8.69,0,0,1,5,8,5,5,0,0,1,6.46,4.46a5,5,0,0,1,7.08,0A5,5,0,0,1,15,8,8.59,8.59,0,0,1,13.51,12.17Z"/>
                                                        <path d="M10,5a3,3,0,1,0,3,3A3,3,0,0,0,10,5Zm0,4a1,1,0,1,1,1-1A1,1,0,0,1,10,9Z"/>
                                                    </svg>
                                                </i><!-- .jt-icon -->
                                                <span class="jt-typo--15">{{ number_format($attraction->distance) }}km</span>
                                            </div><!-- .introduce-local-attractions-lounge__distance -->
                                        </div><!-- .introduce-local-attractions-lounge__title-->

                                        <p class="introduce-local-attractions-lounge__desc jt-typo--13">{!! nl2br(e($attraction->content)) !!}</p>

                                        @if(!empty($attraction->source))
                                        <blockquote class="introduce-local-attractions-lounge__source">
                                            <cite class="jt-typo--17">{!! __('front.local-attractions.source') !!} : {{ $attraction->source }}</cite>
                                        </blockquote><!-- .introduce-local-attractions-lounge__source -->
                                        @endif
                                    </div><!-- .introduce-local-attractions-lounge__data -->
                                </li>
                            @endforeach
                        </ul><!-- .introduce-local-attractions-lounge__list -->
                    </div><!-- .introduce-local-attractions-lounge__content -->
                </div><!-- .introduce-local-attractions-lounge__container -->
            </div><!-- .wrap -->
        </div><!-- .introduce-local-attractions-lounge -->

    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
