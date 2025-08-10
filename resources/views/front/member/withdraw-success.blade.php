@extends('front.partials.layout', [
    'view' => 'register-withdraw-success',
    'seo_title' => __('front.withdraw.success.title'),
    'seo_description' => __('front.desc.withdraw-success'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">{!! __('front.withdraw.success.title') !!}</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                @include('front.partials.take', [
                    'title' =>  __('front.withdraw.success.desc'),
                    'desc' => '',
                    'link' => [
                        'href' => jt_route('index'),
                        'text' => __('front.ui.go-home'),
                        'nobarba' => '1'
                    ]
                ])
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection
