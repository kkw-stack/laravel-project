@extends('front.partials.layout', [
    'view' => 'register-form',
    'seo_title' => __('front.register.modify.title'),
    'seo_description' => __('front.desc.register-modify'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">{!! __('front.register.modify.title') !!}</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    @php
    $currentLang = app()->getLocale();
    $locations = LOCATIONS[app()->getLocale()] ?? LOCATIONS['ko'];
    $sources = [
        '검색포탈 이용',
        'SNS 광고',
        '지인 추천',
    ];
    @endphp

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                @session('success-message')
                <div class="register-form__message">
                    <i class="jt-icon">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M3.28,10l5.05,5.27,8.39-8.75a1,1,0,0,0-1.44-1.38L8.33,12.33,4.72,8.56a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42Z"/>
                        </svg>
                    </i><!-- .jt-icon -->
                    <span class="jt-typo--15">{{ $value }}</span>
                </div><!-- .register-form__message -->
                @endsession

                <form class="jt-form" method="post" novalidate>
                    @csrf

                    <fieldset class="jt-form__fieldset">
                        @if ($currentLang === 'ko')
                            <div class="jt-form__entry jt-form--required">
                                <label class="jt-form__label" for="name"><span class="jt-typo--12">이름</span></label>
                                <div class="jt-form__data">
                                    <input
                                        type="text"
                                        class="jt-form__field jt-form__field--valid"
                                        id="name"
                                        readonly
                                        value="{{ $user->name }}"
                                    />
                                </div><!-- .jt-form__data -->
                            </div><!-- .jt-form__entry -->

                            <div class="jt-form__entry jt-form--required">
                                <label class="jt-form__label" for="phone"><span class="jt-typo--12">휴대폰번호</span></label>
                                <div class="jt-form__data">
                                    <div class="jt-form__data-group">
                                        <input
                                            type="tel"
                                            class="jt-form__field jt-form__field--valid"
                                            id="phone"
                                            readonly
                                            value="{{ $user->mobile }}"
                                        />
                                        <button id="btnChangePhone" type="button"><span class="jt-typo--15">변경</span></button>
                                    </div><!-- .jt-form__data-group -->
                                </div><!-- .jt-form__data -->
                            </div><!-- .jt-form__entry -->
                        @endif

                        <div class="jt-form__entry jt-form--required">
                            <label class="jt-form__label" for="email"><span class="jt-typo--12">{!! __('front.register.form.email.label') !!}</span></label>
                            <div class="jt-form__data">
                                <input
                                    type="email"
                                    class="jt-form__field jt-form__field--valid"
                                    id="email"
                                    readonly
                                    value="{{ $user->email }}"
                                />
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        <div class="jt-form__entry">
                            <b class="jt-form__label"><span class="jt-typo--12">{!! __('front.register.form.password.label') !!}</span></b>
                            <div class="jt-form__data">
                                <p class="jt-form__explain jt-typo--17">{!! __('front.register.modify.password.desc', ['URL'=>jt_route('auth.change-password')]) !!}</p>
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        {{--
                        <div class="jt-form__entry">
                            <label class="jt-form__label" for="current-password"><span class="jt-typo--12">현재 비밀번호</span></label>
                            <div @class([
                                'jt-form__data',
                                'jt-form__data--error' => $errors->has('current-password'),
                            ])>
                                <input
                                    type="password"
                                    class="jt-form__field jt-form__field--valid"
                                    id="current-password"
                                    name="current-password"
                                    required
                                    placeholder="{{ __('jt.IN-02') }}"
                                />

                                <p class="jt-form__valid jt-typo--17">@error('current-password'){{ $message }}@enderror</p>

                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        <div class="jt-form__entry">
                            <label class="jt-form__label" for="password"><span class="jt-typo--12">새 비밀번호</span></label>
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

                                @if($errors->has('password'))
                                    <p class="jt-form__valid jt-typo--17">@error('password'){{ $message }}@enderror</p>
                                @else
                                    <p class="jt-form__explain jt-typo--17">{{ __('jt.IN-07') }}</p>
                                @endif

                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        <div class="jt-form__entry">
                            <label class="jt-form__label" for="password-confirm"><span class="jt-typo--12">새 비밀번호 확인</span></label>
                            <div class="jt-form__data">
                                <input
                                    type="password"
                                    class="jt-form__field jt-form__field--valid"
                                    id="password-confirm"
                                    name="password_confirmation"
                                    required
                                    placeholder="비밀번호를 한번 더 입력해주세요."
                                />
                                <p class="jt-form__valid jt-typo--17"></p>
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->
                        --}}

                        <div class="jt-form__entry jt-form--required">
                            <p class="jt-form__label"><span class="jt-typo--12">{!! __('front.register.form.location.label') !!}</span></p>
                            <div @class([
                                'jt-form__data',
                                'jt-form__data--error' => $errors->has('location'),
                            ])>
                                <div class="jt-choices__wrap">
                                    <select
                                        name="location"
                                        class="jt-choices jt-form__field--valid"
                                        required
                                    >
                                        <option value="">{!! __('front.register.form.location.placeholder') !!}</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location }}" @selected(old('location', $user->location) === $location)>{{ $location }}</option>
                                        @endforeach
                                    </select><!-- .jt-choices -->
                                </div><!-- .jt-choices__wrap -->

                                <p class="jt-form__valid jt-typo--17">@error('location'){{ $message }}@enderror</p>

                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        <div class="jt-form__entry">
                            <p class="jt-form__label"><span class="jt-typo--12">{!! __('front.register.form.notification.label') !!}</span></p>
                            <div class="jt-form__data">
                                <div class="jt-checkbox">
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="marketing"
                                            value="1"
                                            @checked(!empty(old('marketing', $user->marketing)))
                                        />
                                        <span>
                                            {!! __('front.register.form.notification.text') !!}
                                            @if($user->marketing)
                                                <i>({!! __('front.register.modify.notification.date', ['DATE'=>$user->marketing_updated_at->format('Y. m. d H:i')]) !!})</i>
                                            @endif
                                        </span>
                                    </label>
                                </div><!-- .jt-checkbox -->
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->
                        
                        @if($user->google_id || $currentLang === 'ko')
                            <div class="jt-form__entry">
                                <p class="jt-form__label"><span class="jt-typo--12">{!! __('front.register.modify.sns.label') !!}</span></p>
                                <div class="jt-form__data">
                                    <div class="register-form__social">

                                        @if($user->kakao_id || $user->naver_id || $user->google_id)
                                            @if($user->kakao_id)
                                                <div class="register-form__social-item register-form__social--kakao">
                                                    <div class="register-form__social-title">
                                                        <span class="register-form__social-icon">
                                                            <i class="jt-icon">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M12.0482 4C7.33195 4 3.5 7.1 3.5 10.9C3.5 13.3 5.07208 15.4 7.33195 16.7L6.74242 20L10.3779 17.6C10.8691 17.7 11.4587 17.7 11.9499 17.7C16.6662 17.7 20.4982 14.6 20.4982 10.8C20.5964 7.1 16.7645 4 12.0482 4Z" />
                                                                </svg>
                                                            </i><!-- .jt-icon -->
                                                        </span><!-- .register-form__social-icon -->
                                                        <b class="register-form__social-name jt-typo--15">카카오 간편로그인</b>
                                                    </div><!-- .register-form__social-title -->

                                                    <time class="jt-typo--15" datetime="{{ $user->kakao_connected->format('Y-m-d') }}">{!! __('front.register.success.date', ['DATE'=>$user->kakao_connected->format('Y. m. d')]) !!}</time>
                                                </div><!-- .register-form__social-item -->
                                            @endif

                                            @if($user->naver_id)
                                                <div class="register-form__social-item register-form__social--naver">
                                                    <div class="register-form__social-title">
                                                        <span class="register-form__social-icon">
                                                            <i class="jt-icon">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M14.6817 4.5V12.1271L9.31831 4.5H3.5625V19.5H9.31831V12L14.6817 19.5H20.4375V4.5H14.6817Z"/>
                                                                </svg>
                                                            </i><!-- .jt-icon -->
                                                        </span><!-- .register-form__social-icon -->
                                                        <b class="jt-typo--15">네이버 간편로그인</b>
                                                    </div><!-- .register-form__social-title -->

                                                    <time class="jt-typo--15" datetime="{{ $user->naver_connected->format('Y-m-d') }}">{!! __('front.register.success.date', ['DATE'=>$user->naver_connected->format('Y. m. d')]) !!}</time>
                                                </div><!-- .register-form__social-item -->
                                            @endif

                                            @if($user->google_id)
                                                <div class="register-form__social-item register-form__social--google">
                                                    <div class="register-form__social-title">
                                                        <span class="register-form__social-icon">
                                                            <i class="jt-icon">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M21.9435 12.1459C21.9435 11.4426 21.8804 10.7664 21.7632 10.1172H12.4219V13.9538H17.7598C17.5298 15.1936 16.831 16.244 15.7806 16.9473V19.4359H18.986C20.8615 17.7092 21.9435 15.1665 21.9435 12.1459Z" fill="#4285F4"/>
                                                                    <path d="M12.4259 21.8386C15.1039 21.8386 17.349 20.9504 18.9901 19.4356L15.7846 16.947C14.8965 17.5421 13.7604 17.8938 12.4259 17.8938C9.84263 17.8938 7.65608 16.149 6.87614 13.8047H3.5625V16.3744C5.19452 19.616 8.54873 21.8386 12.4259 21.8386Z" fill="#34A853"/>
                                                                    <path d="M6.86859 13.7997C6.67022 13.2046 6.55752 12.5689 6.55752 11.9152C6.55752 11.2615 6.67022 10.6258 6.86859 10.0307V7.46094H3.55495C2.88321 8.79992 2.5 10.3147 2.5 11.9152C2.5 13.5157 2.88321 15.0305 3.55495 16.3694L6.86859 13.7997Z" fill="#FBBC05"/>
                                                                    <path d="M12.4259 5.94481C13.8821 5.94481 15.1895 6.44523 16.2174 7.42805L19.0622 4.58328C17.3445 2.98282 15.0994 2 12.4259 2C8.54873 2 5.19452 4.22262 3.5625 7.46412L6.87614 10.0339C7.65608 7.68954 9.84263 5.94481 12.4259 5.94481Z" fill="#EA4335"/>
                                                                </svg>
                                                            </i><!-- .jt-icon -->
                                                        </span><!-- .register-form__social-icon -->
                                                        <b class="jt-typo--15">Google Account</b>
                                                    </div><!-- .register-form__social-title -->

                                                    <time class="jt-typo--15" datetime="{{ $user->google_connected->format('Y-m-d') }}">{!! __('front.register.success.date', ['DATE'=>$user->google_connected->format('Y. m. d')]) !!}</time>
                                                </div><!-- .register-form__social-item -->
                                            @endif
                                        @else
                                            <p class="register-form__social-empty jt-typo--15">{!! __('front.register.modify.sns.empty') !!}</p>
                                        @endif
                                    </div><!-- .register-form__social -->
                                </div><!-- .jt-form__data -->
                            </div><!-- .jt-form__entry -->
                        @endif
                    </fieldset><!-- .jt-form__fieldset -->

                    <p class="register-form__explain jt-typo--15">{!! __('front.register.modify.withdraw', ['URL'=>jt_route('member.withdraw.form')]) !!}</p>

                    <div class="jt-form__control">
                        <button type="submit" class="jt-form__action"><span class="jt-typo--12">{!! __('front.register.modify.submit') !!}</span></button>
                    </div><!-- .jt-form__control -->
                </form><!-- .jt-form -->
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->

<form data-action="{{ $nice_url }}" class="jt-profile__action--change" novalidate>
    @foreach($nice_data as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
    @endforeach
</form>
@endsection

@push('script')
<script>
    @session('error-message')
        JT.confirm('{!! $value !!}');
    @endsession

    const form = document.querySelector('.jt-form');

    JT.globals.validation(form, {
        disable: true,
        on: {
            success: () => {
                form.submit();
            }
        }
    });

    @if ($currentLang === 'ko')
    document.getElementById('btnChangePhone').addEventListener('click', function () {
        const formChangeNiceData = document.querySelector('.jt-profile__action--change');
        const formData = new FormData(formChangeNiceData);
        const queryString = new URLSearchParams(formData).toString();
        const url = formChangeNiceData.dataset.action + (queryString.length > 0 ? '?' + queryString : '');

        JT.globals.popupWin(url, {
            title: 'niceapi',
            width: 480,
            height: 800
        });
    });
    @endif
</script>
@endpush
