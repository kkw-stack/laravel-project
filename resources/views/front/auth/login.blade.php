@extends('front.partials.layout', [
    'view' => 'user-login',
    'seo_title' => __('front.login.title'),
    'seo_description' => __('front.desc.login'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">{!! __('front.login.title') !!}</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                <div class="user-login-form">
                    <form class="jt-form" method="post" novalidate>
                        @csrf

                        <fieldset class="jt-form__fieldset">
                            <div class="jt-form__entry">
                                <label class="jt-form__label" for="email"><span class="sr-only">{!! __('front.login.email') !!}</span></label>
                                <div @class([
                                    'jt-form__data',
                                    'jt-form__data--error' => $errors->has('email'),
                                ])>
                                    <input
                                        type="email"
                                        class="jt-form__field jt-form__field--valid"
                                        id="email"
                                        name="email"
                                        required
                                        placeholder="{{ __('jt.IN-01') }}"
                                    />

                                    <p class="jt-form__valid jt-typo--17">@error('email'){{ $message }}@enderror</p>

                                </div><!-- .jt-form__data -->
                            </div><!-- .jt-form__entry -->

                            <div class="jt-form__entry">
                                <label class="jt-form__label" for="password"><span class="sr-only">{!! __('front.login.password') !!}</span></label>
                                <div @class([
                                    'jt-form__data',
                                    'jt-form__data--error' => $errors->has('password'),
                                ])>
                                    <input
                                        type="password"
                                        class="jt-form__field jt-form__field--valid"
                                        id="password"
                                        name="password"
                                        required
                                        placeholder="{{ __('jt.IN-02') }}"
                                    />

                                    <p class="jt-form__valid jt-typo--17">@error('password'){{ $message }}@enderror</p>

                                </div><!-- .jt-form__data -->
                            </div><!-- .jt-form__entry -->
                        </fieldset><!-- .jt-form__fieldset -->

                        <div class="jt-form__control">
                            <button type="submit" class="jt-form__action"><span class="jt-typo--12">{!! __('front.ui.go-login') !!}</span></button>
                        </div><!-- .jt-form__control -->
                    </form><!-- .jt-form -->

                    <div class="user-login-utils">
                        @if(app()->getLocale() !== 'en')
                            <a href="{{ jt_route('auth.find-id') }}" data-barba-prevent><span class="jt-typo--15">아이디 찾기</span></a>
                        @endif
                        <a href="{{ jt_route('auth.change-password') }}" data-barba-prevent><span class="jt-typo--15">{!! __('front.login.link.change-password') !!}</span></a>
                        <a href="{{ jt_route('auth.register') }}" data-barba-prevent><span class="jt-typo--15">{!! __('front.login.link.register') !!}</span></a>
                    </div><!-- .user-login-utils -->

                    <div class="user-login-etc">
                        @if(app()->getLocale() !== 'en')
                            @if(!empty($kakao_url))
                                <a href="{{ $kakao_url }}" class="user-login-etc__btn user-login-etc--kakao">
                                    <i class="jt-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.0482 4C7.33195 4 3.5 7.1 3.5 10.9C3.5 13.3 5.07208 15.4 7.33195 16.7L6.74242 20L10.3779 17.6C10.8691 17.7 11.4587 17.7 11.9499 17.7C16.6662 17.7 20.4982 14.6 20.4982 10.8C20.5964 7.1 16.7645 4 12.0482 4Z" />
                                        </svg>
                                    </i><!-- .jt-icon -->
                                    <span class="jt-typo--15">카카오 간편 로그인</span>
                                </a><!-- .user-login-etc--kakao -->
                            @endif

                            @if(!empty($naver_url))
                                <a href="{{ $naver_url }}" class="user-login-etc__btn user-login-etc--naver">
                                    <i class="jt-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.6817 4.5V12.1271L9.31831 4.5H3.5625V19.5H9.31831V12L14.6817 19.5H20.4375V4.5H14.6817Z"/>
                                        </svg>
                                    </i><!-- .jt-icon -->
                                    <span class="jt-typo--15">네이버 간편 로그인</span>
                                </a><!-- .user-login-etc--naver -->
                            @endif

                            <a href="{{ jt_route('member.reservation.list') }}" class="user-login-etc__btn user-login-etc--guest"><span class="jt-typo--12">비회원 예약조회</span></a>
                        @else
                            @if(!empty($google_url))
                                <a href="{{ $google_url }}" class="user-login-etc__btn user-login-etc--google">
                                    <i class="jt-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.9435 12.1459C21.9435 11.4426 21.8804 10.7664 21.7632 10.1172H12.4219V13.9538H17.7598C17.5298 15.1936 16.831 16.244 15.7806 16.9473V19.4359H18.986C20.8615 17.7092 21.9435 15.1665 21.9435 12.1459Z" fill="#4285F4"/>
                                            <path d="M12.4259 21.8386C15.1039 21.8386 17.349 20.9504 18.9901 19.4356L15.7846 16.947C14.8965 17.5421 13.7604 17.8938 12.4259 17.8938C9.84263 17.8938 7.65608 16.149 6.87614 13.8047H3.5625V16.3744C5.19452 19.616 8.54873 21.8386 12.4259 21.8386Z" fill="#34A853"/>
                                            <path d="M6.86859 13.7997C6.67022 13.2046 6.55752 12.5689 6.55752 11.9152C6.55752 11.2615 6.67022 10.6258 6.86859 10.0307V7.46094H3.55495C2.88321 8.79992 2.5 10.3147 2.5 11.9152C2.5 13.5157 2.88321 15.0305 3.55495 16.3694L6.86859 13.7997Z" fill="#FBBC05"/>
                                            <path d="M12.4259 5.94481C13.8821 5.94481 15.1895 6.44523 16.2174 7.42805L19.0622 4.58328C17.3445 2.98282 15.0994 2 12.4259 2C8.54873 2 5.19452 4.22262 3.5625 7.46412L6.87614 10.0339C7.65608 7.68954 9.84263 5.94481 12.4259 5.94481Z" fill="#EA4335"/>
                                        </svg>
                                    </i><!-- .jt-icon -->
                                <span class="jt-typo--15">Sign in with Google</span>
                                </a><!-- .user-login-etc--google -->
                            @endif
                        @endif
                    </div><!-- .user-login-etc -->
                </div><!-- .user-login-form -->
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection

@push('script')
<script>

    const form = document.querySelector('.jt-form');

    JT.globals.validation(form, {
        disable: true,
        on: {
            success: () => {
                form.submit();
            }
        }
    });

</script>
@endpush
