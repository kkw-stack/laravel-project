@extends('front.partials.layout', [
    'view' => 'user-find-id',
    'seo_title' => '아이디 찾기',
    'seo_description' => '',
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">아이디 찾기</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                @include('front.partials.take', [
                    'title' => '등록된 아이디를 찾을 수 없습니다.',
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
