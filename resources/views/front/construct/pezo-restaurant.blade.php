@extends('front.partials.layout', [
    'view' => 'construct-pezo-restaurant',
    'seo_title' => __('front.pezo-restaurant.title'),
    'seo_description' => __('front.desc.pezo-restaurant'),
])

@section('content')

<div class="article">

    @include('front.construct.partials.construct-visual', ['list' => [
        ['type' => 'video', 'title' => __('front.pezo-restaurant.visual.title'), 'desc' => __('front.pezo-restaurant.visual.desc')[0], 'poster' => [ 'desktop' => '/assets/front/images/sub/construct-pezo-restaurant-visual-01-poster.jpg', 'mobile' => '/assets/front/images/sub/construct-pezo-restaurant-visual-01-mobile-poster.jpg' ], 'video' => [ 'desktop' => 'https://player.vimeo.com/progressive_redirect/playback/970440489/rendition/1080p/file.mp4?loc=external&signature=02b250b70347c76c7800f9db84de911005fd20d72ed678dbb65ede383dff3ea5', 'mobile' => 'https://player.vimeo.com/progressive_redirect/playback/970454599/rendition/1080p/file.mp4?loc=external&signature=2f1162e89ed20b3f484c8ea02a9eb271674086022ea494fdc46089d78ca0f959' ]],
        ['type' => 'video', 'desc' => __('front.pezo-restaurant.visual.desc')[1], 'poster' => [ 'desktop' => '/assets/front/images/sub/construct-pezo-restaurant-visual-02-poster.jpg', 'mobile' => '/assets/front/images/sub/construct-pezo-restaurant-visual-02-mobile-poster.jpg' ], 'video' => [ 'desktop' => 'https://player.vimeo.com/progressive_redirect/playback/970440541/rendition/1080p/file.mp4?loc=external&signature=d0712bcf297a77ad0aede5fe8529d89646e5ad78726642852dd8c235b3f8b885', 'mobile' => 'https://player.vimeo.com/progressive_redirect/playback/970454636/rendition/1080p/file.mp4?loc=external&signature=581d8924513f63daa2a52130311faafbdea9c13c5aef954a3b76f628c3faab80' ]],
        ['type' => 'image', 'desc' => __('front.pezo-restaurant.visual.desc')[2], 'image' => [ 'desktop' => '/assets/front/images/sub/construct-pezo-restaurant-visual-03.jpg?v1.1', 'mobile' => '/assets/front/images/sub/construct-pezo-restaurant-visual-03-mobile.jpg?v1.1' ]],
    ]])

</div><!-- .article -->

@endsection
