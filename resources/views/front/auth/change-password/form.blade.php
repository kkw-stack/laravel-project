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
                <h2 class="article__section-title jt-typo--06">안전한 새 비밀번호를 설정하시고 <br />메덩골정원을 계속 이용하세요.</h2>

                <div class="jt-register-history">
                    @include('front.auth.partials.account-history', compact('user'))
                </div><!-- .jt-register-history -->

                <form class="jt-form" method="post" novalidate>
                    @csrf

                    <fieldset class="jt-form__fieldset">
                        <div class="jt-form__entry jt-form--required">
                            <label class="jt-form__label" for="new-password"><span class="jt-typo--12">새 비밀번호</span></label>
                            <div @class([
                                'jt-form__data',
                                'jt-form__data--error' => $errors->has('password'),
                            ])>
                                <input
                                    type="password"
                                    class="jt-form__field jt-form__field--valid"
                                    id="new-password"
                                    name="password"
                                    required
                                    maxlength="50"
                                    placeholder="새 비밀번호를 입력해주세요."
                                />

                                @if($errors->has('password'))
                                    <p class="jt-form__valid jt-typo--17">@error('password'){{ $message }}@enderror</p>
                                @else
                                    <p class="jt-form__explain jt-typo--17">{{ __('jt.IN-07') }}</p>
                                @endif
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        <div class="jt-form__entry jt-form--required">
                            <label class="jt-form__label" for="new-password-confirm"><span class="jt-typo--12">새 비밀번호 확인</span></label>
                            <div class="jt-form__data">
                                <input
                                    type="password"
                                    class="jt-form__field jt-form__field--valid"
                                    id="new-password-confirm"
                                    name="password_confirmation"
                                    required
                                    maxlength="50"
                                    placeholder="새 비밀번호를 한번 더 입력해주세요."
                                />
                                <p class="jt-form__valid jt-typo--17"></p>
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->
                    </fieldset><!-- .jt-form__fieldset -->

                    <div class="jt-form__control">
                        <button type="submit" class="jt-form__action"><span class="jt-typo--12">비밀번호 변경</span></button>
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
