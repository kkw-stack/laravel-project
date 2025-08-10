@extends('front.partials.layout', [
    'view' => 'reservation-payment',
    'seo_title' => __('front.reservation.payment.title'),
    'seo_description' => __('front.desc.reservation-payment'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-narrow">
            <h1 class="article__title jt-typo--02">{!! __('front.reservation.payment.title') !!}</h1>
        </div><!-- .wrap-narrow -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-narrow">
                <div class="jt-reservation">
                    <form class="jt-form" method="post" novalidate>
                        <div class="jt-reservation__inner">
                            <div class="jt-reservation__form">
                                <fieldset class="jt-form__fieldset">
                                    <div class="jt-form__entry">
                                        <label class="jt-form__label" htmlFor="product"><span class="jt-typo--08">{!! __('front.reservation.payment.info.label') !!}</span></label>
                                        <div class="jt-form__data">
                                            <ul class="jt-reservation__userinfo">
                                                <li>
                                                    <b class="jt-typo--12">{!! __('front.reservation.payment.info.type') !!}</b>
                                                    <ul>
                                                        <li class="jt-typo--13">{{ $reservation?->user_email ?? '비회원' }}</li>
                                                        @if($reservation->user_id > 0)
                                                            @if($reservation->user->naver_id)
                                                                <li class="jt-typo--13">네이버 간편 로그인</li>
                                                            @endif
                                                            @if($reservation->user->kakao_id)
                                                                <li class="jt-typo--13">카카오톡 간편 로그인</li>
                                                            @endif
                                                            @if($reservation->user->google_id)
                                                                <li class="jt-typo--13">Google Account</li>
                                                            @endif
                                                        @endif
                                                    </ul>
                                                </li>
                                                @if(app()->getLocale() !== 'en')
                                                <li>
                                                    <b class="jt-typo--12">이름</b>
                                                    <span class="jt-typo--13">{{ $reservation->user_name }}</span>
                                                </li>
                                                <li>
                                                    <b class="jt-typo--12">휴대폰 번호</b>
                                                    <span class="jt-typo--13">{{ $reservation->user_mobile }}</span>
                                                </li>
                                                @endif
                                            </ul><!-- .jt-reservation__userinfo -->
                                        </div><!-- .jt-form__data -->
                                    </div><!-- .jt-form__entry -->

                                    @if($reservation->amount > 0)
                                        <div class="jt-form__entry">
                                            <label class="jt-form__label" htmlFor="product"><span class="jt-typo--08">{!! __('front.reservation.payment.type.label') !!}</span></label>
                                            <div class="jt-form__data">
                                                <div class="jt-reservation__payment jt-radiobox--required" data-msg-required="{{ __('jt.ME-09') }}">
                                                    <div class="jt-reservation__payment-item">
                                                        <label class="jt-reservation__payment-label">
                                                            <input type="radio" name="payment" value="11" required />
                                                            <span class="jt-typo--15">{!! __('front.reservation.payment.type.credit') !!}</span>
                                                        </label><!-- .jt-reservation__payment-label -->
                                                    </div><!-- .jt-reservation__payment-item -->

                                                    @if( $locale == 'ko' )
                                                        <div class="jt-reservation__payment-item">
                                                            <label class="jt-reservation__payment-label">
                                                                <input type="radio" name="payment" value="21" required />
                                                                <span class="jt-typo--15">{!! __('front.reservation.payment.type.bank') !!}</span>
                                                            </label><!-- .jt-reservation__payment-label -->
                                                        </div><!-- .jt-reservation__payment-item -->
                                                    @endif
                                                </div><!-- .jt-reservation__payment -->

                                                <p class="jt-form__valid jt-typo--17"></p>
                                            </div><!-- .jt-form__data -->
                                        </div><!-- .jt-form__entry -->
                                    @endif

                                    <div class="jt-form__entry">
                                        <label class="jt-form__label" htmlFor="product"><span class="jt-typo--08">{!! __('front.reservation.payment.notice.label') !!}</span></label>
                                        <div class="jt-form__data">
                                            <ul class="jt-reservation__explain">
                                                @foreach ( __('front.reservation.payment.notice.desc') as $desc )
                                                    <li class="jt-typo--15">{!! $desc !!}</li>
                                                @endforeach
                                            </ul><!-- .jt-reservation__explain -->
                                        </div><!-- .jt-form__data -->
                                    </div><!-- .jt-form__entry -->
                                </fieldset><!-- .jt-form__fieldset -->
                            </div><!-- .jt-reservation__form -->

                            <div class="jt-reservation__result">
                                <div class="jt-reservation__result-sticky">
                                    <div class="jt-reservation__result-content">
                                        <div class="jt-reservation__result-content-inner">
                                            <div class="jt-reservation__result-data">
                                                <b class="jt-reservation__result-title jt-typo--05">{{ $reservation->ticket->title[$locale] }}</b>
                                                <ul class="jt-reservation__result-list">
                                                    <li>
                                                        <b class="jt-typo--15">{!! __('front.reservation.result.sector') !!}</b>
                                                        <span class="jt-typo--15">{{ $reservation->ticket->sector[$locale] }}</span>
                                                    </li>
                                                    <li>
                                                        <b class="jt-typo--15">{!! __('front.reservation.result.date') !!}</b>
                                                        <span class="jt-typo--15">{{ 'en' === $locale ? $reservation->select_date->format('l, F j, y') : date_format_korean($reservation->select_date, 'Y년 m월 d일(D)') }}</span>
                                                    </li>
                                                    <li>
                                                        <b class="jt-typo--15">{!! __('front.reservation.result.time') !!}</b>
                                                        <span class="jt-typo--15">{{ 'en' === $locale ? $reservation->select_time->format('A h:i') : date_format_korean($reservation->select_time, 'A h:i') }}{{ $reservation->use_docent ? '(' . __('front.reservation.result.docent') . ')' : '' }}</span>
                                                    </li>
                                                    <li>
                                                        <b class="jt-typo--15">{!! __('front.reservation.result.visitor') !!}</b>
                                                        <span class="jt-typo--15">{{ $reservation->get_visitors_label() }}</span>
                                                    </li>
                                                </ul><!-- .jt-reservation__result-list -->
                                            </div><!-- .jt-reservation__result-data -->

                                            <div class="jt-reservation__result-last">
                                                <div class="jt-reservation__result-price">
                                                    <b class="jt-typo--12">{!! __('front.reservation.result.total') !!}</b>
                                                    <span class="jt-typo--08">{!! __('front.reservation.common.price', ['PRICE' => number_format($reservation->amount)]) !!}</span>
                                                </div><!-- .jt-reservation__result-price -->
                                            </div><!-- .jt-reservation__result-last -->

                                            <div class="jt-form__warning">
                                                <ul class="jt-form__warning-list">
                                                    @foreach ( __('front.reservation.result.warning') as $desc )
                                                        <li class="jt-typo--16">{!! $desc !!}</li>
                                                    @endforeach
                                                </ul><!-- .jt-form__warning-list -->
                                            </div><!-- .jt-form__warning -->
                                        </div><!-- .jt-reservation__result-content-inner -->
                                    </div><!-- .jt-reservation__result-content -->

                                    <div class="jt-reservation__result-agree">
                                        <div class="jt-checkbox">
                                            <label>
                                                <input type="checkbox" name="agree" required />
                                                <span>{{ __('front.reservation.form.agree.text') }}</span>
                                            </label>
                                        </div><!-- .jt-checkbox -->
                                    </div><!-- .jt-reservation__result-agree -->

                                    <div class="jt-reservation__result-payment">
                                        <button type="submit" class="jt-form__action" disabled><span class="jt-typo--12">{!! __('front.reservation.result.submit.payment') !!}</span></button>
                                    </div><!-- .jt-reservation__result-payment -->
                                </div><!-- .jt-reservation__result-sticky -->
                            </div><!-- .jt-reservation__result -->
                        </div><!-- .jt-reservation__inner -->
                    </form><!-- .jt-form -->
                </div><!-- .jt-reservation -->

            </div><!-- .wrap-narrow -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection

@push('script')
<script>
    const form = document.querySelector('.jt-form');

    let isRun = false;
    let popup;

    JT.globals.validation(form, {
        on: {
            success: () => {
                if( isRun ) return;
                isRun = true;

                const formData = new FormData( form );

                formData.append('device', JT.browser('mobile') ? 'mobile' : 'pc');

                // Fake opener ( ios, mac opener not found by popup blocker )
                if( JT.browser('ios') || JT.browser('mac') ){
                    if( ( Number('{{ $reservation->amount }}') || 0 ) > 0 ){
                        popup = JT.globals.popupWin('', {
                            title: 'Easypay',
                            width: 674,
                            height: 552,
                        });
                    }
                }

                fetch(location.href, {
                    method: 'POST',
                    body: formData,
                }).then(res => res.json()).then(data => {
                    if ( data?.success && data?.redirect_to ) {
                        JT.globals.popupWin(data.redirect_to, {
                            title: 'Easypay',
                            width: 674,
                            height: 552
                        });
                    } else {
                        popup?.close();

                        if (data?.message) {
                            JT.confirm(data?.message || 'ERROR', function () {
                                location.href = data?.redirect_to || '{{ jt_route("reservation.form") }}';
                            });
                        } else {
                            location.href = data?.redirect_to || '{{ jt_route("reservation.form") }}';
                        }
                    }

                    isRun = false;
                }).catch(() => {
                    isRun = false;
                })

            }
        }
    });

    form.querySelectorAll('[name="payment"]').forEach(( radio ) => {
        radio.addEventListener('change', inputChange);
    });

    form.querySelectorAll('[name="agree"]').forEach(( radio ) => {
        radio.addEventListener('change', inputChange);
    });

    function inputChange(){

        if( form.checkValidity() ){
            form.querySelector('[type="submit"]').disabled = false;
            gsap.set('.jt-reservation__result-payment', { autoAlpha: 1 });
        } else {
            form.querySelector('[type="submit"]').disabled = true;
            gsap.set('.jt-reservation__result-payment', { autoAlpha: 0 });
        }

    }

    // 세션 유지를 위한 백그라운드 요청
    setInterval(function () {
        fetch('/up').then(response => {});
    }, 60000);
</script>
@endpush
