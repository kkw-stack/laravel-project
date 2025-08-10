@extends('front.partials.layout', [
    'view' => 'introduce-history',
    'seo_title' => __('front.history.title'),
    'seo_description' => __('front.desc.history'),
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--01">{!! __('front.history.title') !!}</h1>
            <p class="article__desc jt-typo--12">{!! __('front.history.desc') !!}</p>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    @include('front.partials.sub-visual', ['images' => [
        ['desktop' => '/assets/front/images/sub/introduce-history-visual-01.jpg', 'mobile' => '/assets/front/images/sub/introduce-history-visual-01-mobile.jpg']
    ]])

    <div class="article__body">

        <div class="article__section introduce-history-lounge">
            <div class="wrap">
                <div class="introduce-history-lounge__container">
                    <div class="introduce-history-lounge__sticky">
                        <div class="introduce-history-lounge__sticky-inner">
                            @foreach($categories as $category)
                                <div class="introduce-history-lounge__sticky-item">
                                    <b class="introduce-history-lounge__range jt-typo--14">{{ $category->title }}</b>

                                    @if(!empty($category->content))
                                        <h2 class="introduce-history-lounge__title jt-typo--03">{!! nl2br(e($category->content)) !!}</h2>
                                    @endif
                                </div><!-- .introduce-history-lounge__sticky-item -->
                            @endforeach
                        </div><!-- .introduce-history-lounge__sticky-inner -->
                    </div><!-- .introduce-history-lounge__sticky -->

                    <div class="introduce-history-lounge__content">
                        @foreach($categories as $category)
                            <div class="introduce-history-lounge__mobile">
                                <b class="introduce-history-lounge__range jt-typo--14">{{ $category->title }}</b>

                                @if(!empty($category->content))
                                    <h2 class="introduce-history-lounge__title jt-typo--03">{!! nl2br(e($category->content)) !!}</h2>
                                @endif
                            </div><!-- .introduce-history-lounge__mobile -->

                            <ul class="introduce-history-lounge__list">
                                @foreach($category->historyList() as $history)
                                    <li>
                                        <h3 class="introduce-history-lounge__year jt-typo--09">{{ $history->year }}</h3>
                                        <ul class="introduce-history-lounge__sublist">
                                            @foreach($history->content as $content)
                                            <li>
                                                <span class="jt-typo--10">{{ $content['content'] }}</span>

                                                @if($content['use_image'] ?? false)
                                                    <i class="jt-icon">
                                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path d="M19,2H5A3,3,0,0,0,2,5V19s0,.05,0,.08v.05A3,3,0,0,0,5,22H19a3,3,0,0,0,3-3V5A3,3,0,0,0,19,2ZM5,4H19a1,1,0,0,1,1,1v9.51l-3-3.35h0a2,2,0,0,0-3,0h0l-4,4.48h0L8.51,14.13a2,2,0,0,0-3,.13h0L4,16.15V5A1,1,0,0,1,5,4Zm10.5,8.49Zm0,0Zm0,0ZM19,20H5a1,1,0,0,1-.94-.72l3-3.77h0L8.53,17h0A2,2,0,0,0,11.46,17h0l4-4.49,4.5,5V19A1,1,0,0,1,19,20Z" />
                                                            <path d="M7.5,11A2.5,2.5,0,1,0,5,8.5,2.5,2.5,0,0,0,7.5,11Zm0-3a.5.5,0,1,1-.5.5A.5.5,0,0,1,7.5,8Z" />
                                                        </svg>
                                                    </i><!-- .jt-icon -->
                                                    <div class="introduce-history-lounge__image introduce-history-lounge__image--{{ $content['size'] }}">
                                                        <figure class="jt-lazyload">
                                                            <span class="jt-lazyload__color-preview"></span>
                                                            <img data-unveil="{{ Storage::url($content['image']) }}" src="/assets/front/images/layout/blank.gif" alt="" />
                                                            <noscript><img src="{{ Storage::url($content['image']) }}" alt="" /></noscript>
                                                        </figure><!-- .jt-lazyload -->
                                                    </div><!-- .introduce-history-lounge__image -->
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul><!-- .introduce-history-lounge__sublist -->
                                    </li>
                                @endforeach
                            </ul><!-- .introduce-history-lounge__list -->
                        @endforeach
                    </div><!-- .introduce-history-lounge__content -->

                    <div class="introduce-history-lounge__sticky-image">
                        <div class="introduce-history-lounge__sticky-image-inner">
                        </div><!-- .introduce-history-lounge__sticky-image-inner -->
                    </div><!-- .introduce-history-lounge__sticky-image -->

                </div><!-- .introduce-history-lounge__container -->
            </div><!-- .wrap -->
        </div><!-- .introduce-history-lounge -->

    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
