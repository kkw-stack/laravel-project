@extends('front.partials.layout', [
    'view' => 'manual-faq',
    'seo_title' => __('front.faq.title'),
    'seo_description' =>  __('front.desc.faq'),
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--02">{!! __('front.faq.title') !!}</h1>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary manual-faq-list">
            <div class="wrap-narrow">

                <div class="jt-category">
                    <a href="{{ jt_route('manual.faq') }}" @class(["jt-category--current" => empty($cate)])><span class="jt-typo--10">{!! __('front.faq.all') !!}</span></a>
                    @foreach($categories as $category)
                        <a href="{{ jt_route('manual.faq', ['cate' => $category->id]) }}" @class(['jt-category--current' => $cate == $category->id])><span class="jt-typo--10">{{ $category->name }}</span></a>
                    @endforeach
                </div><!-- .jt-category -->

                <div class="jt-category__content">
                    @if($faqs->total() > 0)
                        <ul class="jt-accordion">
                            @foreach($faqs as $faq)
                            <li class="jt-accordion__item">
                                <a href="#" class="jt-accordion__head">
                                    <h2 class="jt-accordion__title jt-typo--09">{{ $faq->question }}</h2>
                                    <div class="jt-accordion__control">
                                        <i class="jt-icon">
                                            <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
                                                <path d="M5.3,10.71l8.1,8a1,1,0,0,0,.71.29,1,1,0,0,0,.7-.3l7.9-8a1,1,0,0,0-1.42-1.4l-7.2,7.29L6.7,9.29a1,1,0,0,0-1.4,1.42Z"/>
                                            </svg>
                                        </i><!-- .jt-icon -->
                                    </div><!-- .jt-accordion__control -->
                                </a><!-- .jt-accordion__head -->

                                <div class="jt-accordion__content">
                                    <div class="jt-accordion__content-inner">
                                        <p class="jt-typo--14">{!! nl2br(replace_link($faq->answer)) !!}</p>
                                    </div><!-- .jt-accordion__content-inner -->
                                </div><!-- .jt-accordion__content -->
                            </li><!-- .jt-accordion__item -->
                            @endforeach
                        </ul><!-- .jt-accordion -->

                        {{ $faqs->withQueryString()->links('front.partials.pagination') }}
                    @else
                        @include('front.partials.empty')

                        <div class="jt-controls">
                            <a href="{{ jt_route('index') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.go-home') !!}</span></a>
                        </div><!-- .jt-btns -->
                    @endif
                </div><!-- .jt-category__content -->

            </div><!-- .wrap-narrow -->
        </div><!-- .manual-faq-list -->

    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
