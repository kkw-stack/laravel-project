@extends('front.partials.layout', [
    'view' => 'reservation-success',
    'seo_title' => __('front.reservation.success.title'),
    'seo_description' => __('front.desc.reservaion-success'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">{!! __('front.reservation.success.title') !!}</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                <h2 class="article__section-title jt-typo--06">{!! __('front.reservation.success.desc', ['NAME'=>$reservation->user_name]) !!}</h2>

                <div class="jt-reservation__result">
                    <div class="jt-reservation__result-content">
                        <div class="jt-reservation__result-content-inner">
                            <div class="jt-reservation__result-data">
                                <b class="jt-reservation__result-title jt-typo--06">{{ $reservation->ticket->title[$locale] }}</b>
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
                                    <b class="jt-typo--15">{!! __('front.reservation.result.amount') !!}</b>
                                    <span class="jt-typo--09">{!! __('front.reservation.common.price', ['PRICE'=>number_format($reservation->amount)]) !!}({{ $reservation->get_payment_type() }})</span>
                                </div><!-- .jt-reservation__result-price -->

                                <div class="jt-reservation__result-number">
                                    <b class="jt-typo--15">{!! __('front.reservation.result.number') !!}</b>
                                    <span class="jt-typo--15">{{ $reservation->code }}</span>
                                </div><!-- .jt-reservation__result-number -->
                            </div><!-- .jt-reservation__result-last -->
                        </div><!-- .jt-reservation__result-content-inner -->
                    </div><!-- .jt-reservation__result-content -->

                    <ul class="jt-reservation__explain">
                        @foreach ( __('front.reservation.success.warning') as $desc )
                            <li class="jt-typo--16">{!! $desc !!}</li>
                        @endforeach
                    </ul><!-- .jt-reservation__explain -->

                    <div class="jt-form__control">
                        <a href="{{ jt_route('index') }}" class="jt-btn__basic jt-btn--type-03 jt-btn--large" data-barba-prevent><span class="jt-typo--12">{!! __('front.ui.go-home') !!}</span></a>
                        <a href="{{ jt_route('member.reservation.list') }}" class="jt-btn__basic jt-btn--type-01 jt-btn--large" data-barba-prevent><span class="jt-typo--12">{{ Auth::check() ? __('front.reservation.success.link') : '비회원 예약조회' }}</span></a>
                    </div><!-- .jt-reservation__result-payment -->
                </div><!-- .jt-reservation__result -->

            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection
