@extends('front.partials.layout', [
    'view' => 'register-withdraw',
    'seo_title' => __('front.withdraw.title'),
    'seo_description' => __('front.desc.withdraw'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">{!! __('front.withdraw.form.title') !!}</h1>
            <p class="article__desc jt-typo--15">{!! __('front.withdraw.form.desc') !!}</p>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                <form id="withdrawForm" method="POST" class="jt-form" novalidate>
                    @csrf

                    <fieldset class="jt-form__fieldset">
                        <div class="jt-form__entry jt-form--required">
                            <p class="jt-form__label"><span class="jt-typo--12">{!! __('front.withdraw.form.reason.label') !!}</span></p>
                            <div @class([
                                'jt-form__data',
                                'jt-form__data--error' => $errors->has('reason') || $errors->has('reason_etc'),
                            ])>
                                <div class="jt-choices__wrap">
                                    <select
                                        name="reason"
                                        required
                                        class="jt-choices jt-form__field--valid"
                                    >
                                        <option value="">{{ __('jt.IN-53') }}</option>
                                        @foreach ( __('front.withdraw.form.reason.list') as $reason )
                                            <option value="{{ $reason }}" @selected(old('reason') === $reason)>{{ $reason }}</option>
                                        @endforeach
                                        <option value="etc" @selected(old('reason') === 'etc')>{!! __('front.withdraw.form.reason.etc.text') !!}</option>
                                    </select><!-- .jt-choices -->

                                    <textarea
                                        name="reason_etc"
                                        maxlength="500"
                                        placeholder="{!! __('front.withdraw.form.reason.etc.placeholder', ['LENGTH'=>500]) !!}"
                                        class="jt-form__field"
                                    >{{ old('reason_etc') }}</textarea>

                                    <p class="jt-form__valid jt-typo--17">
                                        @error('reason'){{ $message }}@enderror
                                        @error('reason_etc'){{ $message }}@enderror
                                    </p>
                                </div><!-- .jt-choices__wrap -->

                                <p class="jt-form__valid jt-typo--17"></p>
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        <div class="jt-form__entry jt-form--required">
                            <label class="jt-form__label" for="new-password"><span class="jt-typo--12">{!! __('front.withdraw.form.password.label') !!}</span></label>
                            <div @class([
                                'jt-form__data',
                                'jt-form__data--error' => $errors->has('password'),
                            ])>
                                <input
                                    type="password"
                                    id="new-password"
                                    name="password"
                                    required
                                    maxlength="50"
                                    class="jt-form__field jt-form__field--valid"
                                    placeholder="{{ __('jt.IN-02') }}"
                                />
                                <p class="jt-form__explain jt-typo--17">{!! __('front.withdraw.form.password.explain') !!}</p>
                                <p class="jt-form__valid jt-typo--17">@error('password'){{ $message }}@enderror</p>
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->

                        <div class="jt-form__warning">
                            <b class="jt-form__warning-title jt-typo--12">{!! __('front.withdraw.form.warning.label') !!}</b>
                            <ul class="jt-form__warning-list">
                                @foreach ( __('front.withdraw.form.warning.desc') as $key => $desc )
                                    <li class="jt-typo--15">{!!  __('front.withdraw.form.warning.desc', ['EMAIL'=>'info@mdale.co.kr'])[$key] !!}</li>
                                @endforeach
                            </ul><!-- .jt-form__warning-list -->
                        </div><!-- .jt-form__warning -->
                    </fieldset><!-- .jt-form__fieldset -->

                    <div class="jt-form__control">
                        <button type="submit" class="jt-form__action"><span class="jt-typo--12">{!! __('front.withdraw.form.submit') !!}</span></button>
                    </div><!-- .jt-form__control -->
                </form><!-- .jt-form -->
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection

@pushif(!Auth::user()->can_withdraw(), 'script')
<script>
let allowWithdraw = false;

const form = document.getElementById('withdrawForm');

form.addEventListener('submit', function (e) {
    if (!allowWithdraw) {
        e.preventDefault();
        e.stopPropagation();

        JT.confirm({
            message: '{!! __("jt.CA-11") !!}',
            confirm     : '{!! __("front.withdraw.form.modal.confirm") !!}',
            cancel      : '{!! __("front.withdraw.form.modal.cancel") !!}',
            isChoice: true,
            onConfirm: function () {
                allowWithdraw = true;
                form.submit();
            },
        });

        return false;
    }

    return true;
});
</script>
@endpushif
