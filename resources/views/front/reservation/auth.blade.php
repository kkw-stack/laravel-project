@extends('front.partials.layout', [
    'view' => 'reservation-cert',
    'seo_title' => '비회원 본인인증',
    'seo_description' => '',
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">비회원 본인인증</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                <h2 class="article__section-title jt-typo--06">메덩골정원 비회원 예약을 위해 <br />약관동의 및 본인인증 서비스를 이용해주세요.</h2>

                <form data-action="{{ $nice_url }}" class="jt-form" novalidate>
                    @foreach($nice_data as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                    @endforeach

                    <div class="jt-agreement">
                        <div class="jt-agreement__head">
                            <div class="jt-agreement__item jt-agreement--all">
                                <div class="jt-checkbox">
                                    <label><input type="checkbox"><span>전체 약관 동의</span></label>
                                </div><!-- .jt-checkbox -->
                            </div><!-- .jt-agreement__item -->
                        </div><!-- .jt-agreement__head -->

                        <div class="jt-agreement__body">
                            <div class="jt-agreement__item">
                                <div class="jt-checkbox">
                                    <label><input type="checkbox" value="" required><span>[필수] 만 14세 이상입니다.</span></label>
                                </div><!-- .jt-checkbox -->
                            </div><!-- .jt-agreement__item -->

                            <div class="jt-agreement__item">
                                <div class="jt-checkbox">
                                    <label><input type="checkbox" value="" required><span>[필수] 이용약관 동의</span></label>
                                </div><!-- .jt-checkbox -->
                                <a href="{{ jt_route('policy.terms') }}" class="jt-agreement__more"><span class="jt-typo--17">자세히보기</span></a>
                            </div><!-- .jt-agreement__item -->

                            <div class="jt-agreement__item">
                                <div class="jt-checkbox">
                                    <label><input type="checkbox" value="" required><span>[필수] 개인정보 수집 및 이용</span></label>
                                </div><!-- .jt-checkbox -->
                                <a href="{{ jt_route('policy.privacy') }}" class="jt-agreement__more"><span class="jt-typo--17">자세히보기</span></a>
                            </div><!-- .jt-agreement__item -->
                        </div><!-- .jt-agreement__body -->

                        <p class="jt-form__valid jt-typo--17"></p>

                    </div><!-- .jt-agreement -->

                    <div class="jt-form__control">
                        <button type="submit" class="jt-form__action"><span class="jt-typo--12">본인인증 하기</span></button>
                    </div><!-- .jt-form__control -->
                </form><!-- .jt-form -->
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection

@push('popup')
    <div class="jt-agreement-popup jt-popup">
        <div class="jt-popup__container">
            <div class="jt-popup__container-inner">
            </div><!-- .jt-popup__container-inner -->

            <button class="jt-popup__close">
                <span class="sr-only">{!! __('front.ui.close-popup') !!}</span>
                <i class="jt-icon">
                    <svg width="52" height="52" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <path d="M47.23,45.8,27.43,26,47.22,6.21a1,1,0,0,0-1.41-1.42L26,24.59,6.22,4.79A1,1,0,0,0,4.81,6.21L24.6,26,4.8,45.8a1,1,0,0,0,1.41,1.42L26,27.41l19.8,19.81a1,1,0,0,0,.71.29,1,1,0,0,0,.7-1.71Z"></path>
                    </svg>
                </i><!-- .jt-icon -->
            </button><!-- .jt-popup__close -->
        </div><!-- .jt-popup__container -->
    </div><!-- .jt-agreement-popup -->
@endpush

@push('script')
<script>
    const form = document.querySelector('.jt-form');

    JT.globals.validation(form, {
        on: {
            valid:  () => {
                let isError = false;

                const agreement = form.querySelector('.jt-agreement');

                agreement.querySelectorAll('input[type="checkbox"][required]').forEach(( checkbox ) => {
                    if( !checkbox.checked ) isError = true;
                });

                if( isError ){
                    agreement.querySelector('.jt-form__valid').textContent = '{{ __("jt.IN-56") }}';
                } else {
                    agreement.querySelector('.jt-form__valid').textContent = '';
                }

                return !isError;

            },
            success: () => {
                const formData = new FormData(form);
                const queryString = new URLSearchParams(formData).toString();
                const url = form.dataset.action + (queryString.length > 0 ? '?' + queryString : '');

                JT.globals.popupWin(url, {
                    title: 'niceapi',
                    width: 480,
                    height: 800
                });
            }
        }
    });
</script>
@endpush
