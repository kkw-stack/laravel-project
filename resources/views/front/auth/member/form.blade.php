@extends('front.partials.layout', [
    'view' => 'register-form',
    'seo_title' => __('front.register.form.title'),
    'seo_description' => __('front.desc.register-form'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">{!! __('front.register.form.title') !!}</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    @php
    $currentLang = app()->getLocale();
    $locations = LOCATIONS[$currentLang] ?? LOCATIONS['ko'];
    $sources = [
        '검색포탈 이용',
        'SNS 광고',
        '지인 추천',
    ];
    @endphp

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                @if ($currentLang === 'ko')
                    <div class="register-form__message">
                        <i class="jt-icon">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M3.28,10l5.05,5.27,8.39-8.75a1,1,0,0,0-1.44-1.38L8.33,12.33,4.72,8.56a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42Z"/>
                            </svg>
                        </i><!-- .jt-icon -->
                        <span class="jt-typo--15">본인인증이 완료되었습니다</span>
                    </div><!-- .register-form__message -->
                @endif

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
                                        value="{{ $nice_data['name'] }}"
                                    />
                                    <p class="jt-form__valid jt-typo--17"></p>
                                </div><!-- .jt-form__data -->
                            </div><!-- .jt-form__entry -->

                            <div class="jt-form__entry jt-form--required">
                                <label class="jt-form__label" for="phone"><span class="jt-typo--12">휴대폰번호</span></label>
                                <div class="jt-form__data">
                                    <input
                                        type="tel"
                                        class="jt-form__field jt-form__field--valid"
                                        id="phone"
                                        readonly
                                        value="{{ $nice_data['mobile'] }}"
                                    />
                                    <p class="jt-form__valid jt-typo--17"></p>
                                </div><!-- .jt-form__data -->
                            </div><!-- .jt-form__entry -->
                        @endif

                        <div class="jt-form__entry jt-form--required">
                            <label class="jt-form__label" for="email"><span class="jt-typo--12">{!! __('front.register.form.email.label') !!}</span></label>
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
                                    value="{{ old('email', $social_email ?? '') }}"
                                />

                                <p class="jt-form__valid jt-typo--17">@error('email'){{ $message }}@enderror</p>
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        <div class="jt-form__entry jt-form--required">
                            <label class="jt-form__label" for="password"><span class="jt-typo--12">{!! __('front.register.form.password.label') !!}</span></label>
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
                                    autocomplete="new-password"
                                />

                                @if($errors->has('password'))
                                    <p class="jt-form__valid jt-typo--17">@error('password'){{ $message }}@enderror</p>
                                @else
                                    <p class="jt-form__explain jt-typo--17">{{ __('jt.IN-07') }}</p>
                                @endif

                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        <div class="jt-form__entry jt-form--required">
                            <label class="jt-form__label" for="password-confirm"><span class="jt-typo--12">{!! __('front.register.form.password-confirm.label') !!}</span></label>
                            <div class="jt-form__data">
                                <input
                                    type="password"
                                    class="jt-form__field jt-form__field--valid"
                                    id="password-confirm"
                                    name="password_confirmation"
                                    required
                                    placeholder="{!! __('front.register.form.password-confirm.placeholder') !!}"
                                />
                                <p class="jt-form__valid jt-typo--17"></p>
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

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
                                            <option value="{{ $location }}" @selected(old('location') === $location)>{{ $location }}</option>
                                        @endforeach
                                    </select><!-- .jt-choices -->
                                </div><!-- .jt-choices__wrap -->

                                <p class="jt-form__valid jt-typo--17">@error('location'){{ $message }}@enderror</p>

                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        @if ($currentLang === 'ko')                                
                            <div class="jt-form__entry">
                                <p class="jt-form__label"><span class="jt-typo--12">가입 경로</span></p>
                                <div @class([
                                    'jt-form__data',
                                    'jt-form__data--error' => $errors->has('source') || $errors->has('source_etc'),
                                ])>
                                    <div class="jt-choices__wrap">
                                        <select name="source" class="jt-choices">
                                            <option value="">선택해주세요.</option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source }}" @selected(old('source') === $source)>{{ $source }}</option>
                                            @endforeach
                                            <option value="기타" @selected(old('source') === '기타')>기타</option>
                                        </select><!-- .jt-choices -->

                                        <textarea
                                            class="jt-form__field"
                                            name="source_etc"
                                            maxlength="100"
                                            placeholder="기타 가입 경로를 작성해주세요.(공백포함, 100자 이내)"
                                        >{{ old('source_etc') }}</textarea>
                                    </div><!-- .jt-choices__wrap -->

                                    <p class="jt-form__valid jt-typo--17">@error('source'){{ $message }}@enderror</p>
                                    <p class="jt-form__valid jt-typo--17">@error('source_etc'){{ $message }}@enderror</p>

                                </div><!-- .jt-form__data -->
                            </div><!-- .jt-form__entry -->
                        @endif

                        <div class="jt-form__entry">
                            <p class="jt-form__label"><span class="jt-typo--12">{!! __('front.register.form.notification.label') !!}</span></p>
                            <div class="jt-form__data">
                                <div class="jt-checkbox">
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="marketing"
                                            value="1"
                                            @checked(!empty(old('marketing')))
                                        />
                                        <span>{!! __('front.register.form.notification.text') !!}</span>
                                    </label>
                                </div><!-- .jt-checkbox -->
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->
                    </fieldset><!-- .jt-form__fieldset -->

                    <div class="jt-form__control">
                        <button type="submit" class="jt-form__action"><span class="jt-typo--12">{!! __('front.register.form.submit') !!}</span></button>
                    </div><!-- .jt-form__control -->
                </form><!-- .jt-form -->
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
