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
                <h2 class="article__section-title jt-typo--06">{{ $user->name }} 회원님, <br />가입하신 메덩골정원 아이디입니다.</h2>

                <div class="jt-register-history">
                    @include('front.auth.partials.account-history', compact('user'))

                    <p class="jt-register-history__explain">
                        <i class="jt-icon">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12,3a9,9,0,1,0,9,9A9,9,0,0,0,12,3ZM17,17A7,7,0,1,1,19,12,7,7,0,0,1,17,17Z" />
                                <path d="M11 9a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M11 11h2v5H11Z" />
                            </svg>
                        </i><!-- .jt-icon -->
                        <span class="jt-typo--15">이전에 가입하신 계정이 존재합니다. 비밀번호를 잊으셨다면 비밀번호 재설정을 이용해주세요.</span>
                    </p><!-- .jt-register-history__explain -->

                    <div class="jt-form__control">
                        <a href="{{ jt_route('auth.change-password') }}" data-barba-prevent class="jt-btn__basic jt-btn--type-03 jt-btn--large"><span class="jt-typo--12">비밀번호 재설정</span></a>
                        <a href="{{ jt_route('login') }}" data-barba-prevent class="jt-btn__basic jt-btn--type-01 jt-btn--large"><span class="jt-typo--12">로그인 하기</span></a>
                    </div><!-- .jt-form__control -->
                </div><!-- .jt-register-history -->
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection
