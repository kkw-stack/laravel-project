@extends('front.partials.layout', [
    'view' => 'user-change-password',
    'seo_title' => '비밀번호 재설정',
    'seo_description' => '',
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">비밀번호 재설정</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                @include('front.partials.take', [
                    'title' => '새 비밀번호로 변경이 완료되었습니다.',
                    'desc' => '바뀐 비밀번호로 지금 바로 로그인하세요.',
                    'link' => [
                        'href' => jt_route('login'),
                        'text' => '로그인 하기',
                        'nobarba' => '1'
                    ]
                ])
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection
