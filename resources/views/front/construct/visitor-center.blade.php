@extends('front.partials.layout', [
    'view' => 'construct-visitor-center',
    'seo_title' => __('front.visitor-center.title'),
    'seo_description' => __('front.desc.visitor-center'),
])

@section('content')

<div class="article">

    @include('front.construct.partials.construct-visual', ['list' => [
        ['type' => 'video', 'title' => __('front.visitor-center.visual.title'), 'desc' => __('front.visitor-center.visual.desc')[0], 'poster' => [ 'desktop' => '/assets/front/images/sub/construct-visitor-center-visual-01-poster.jpg', 'mobile' => '/assets/front/images/sub/construct-visitor-center-visual-01-mobile-poster.jpg' ], 'video' => [ 'desktop' => 'https://player.vimeo.com/progressive_redirect/playback/970456581/rendition/1080p/file.mp4?loc=external&signature=223cb1b58ba24f40988ecbcccfea4ac20e588b667b5fc1add3fad3425bcc0e0e', 'mobile' => 'https://player.vimeo.com/progressive_redirect/playback/970454556/rendition/1080p/file.mp4?loc=external&signature=7b61054e58a12ede15189b5458a28a5419626de857dab9a06f51b9c062d3180a' ]],
        ['type' => 'video', 'desc' => __('front.visitor-center.visual.desc')[1], 'poster' => [ 'desktop' => '/assets/front/images/sub/construct-visitor-center-visual-02-poster.jpg', 'mobile' => '/assets/front/images/sub/construct-visitor-center-visual-02-mobile-poster.jpg' ], 'video' => [ 'desktop' => 'https://player.vimeo.com/progressive_redirect/playback/970440321/rendition/1080p/file.mp4?loc=external&signature=2d00c158264b963b9a4df0dc5be9dac6f780fe860b659ad16fbb37f497e2254f', 'mobile' => 'https://player.vimeo.com/progressive_redirect/playback/1000599170/rendition/1080p/file.mp4?loc=external&signature=bb440ffa5f63845d90d0ed5637485969710fc5a364fbe6e8a8842bfd2b3a9c0c' ]],
        ['type' => 'image', 'desc' => __('front.visitor-center.visual.desc')[2], 'image' => [ 'desktop' => '/assets/front/images/sub/construct-visitor-center-visual-03.jpg', 'mobile' => '/assets/front/images/sub/construct-visitor-center-visual-03-mobile.jpg' ]],
    ]])

</div><!-- .article -->

@endsection
