@extends('front.partials.layout', [
    'view' => 'user-change-password',
    'seo_title' => 'Reset Password',
    'seo_description' => '',
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">Reset Password</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                @include('front.partials.take', [
                    'title' => '가입하신 내역이 존재하지 않습니다.',
                    'desc' => '지금 바로 메덩골정원에 가입해보세요!',
                    'link' => [
                        'href' => jt_route('auth.register'),
                        'text' => '회원가입 하기',
                        'nobarba' => '1'
                    ]
                ])
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection
