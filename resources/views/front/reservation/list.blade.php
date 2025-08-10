@extends('front.partials.layout', [
    'view' => 'reservation-list',
    'seo_title' => $is_guest ? '비회원 예약조회' : __('front.mypage.title'),
    'seo_description' => __('front.desc.mypage'),
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap-narrow">
            <h1 class="article__title jt-typo--02">{{ $is_guest ? '비회원 예약조회' : __('front.mypage.title') }}</h1>
        </div><!-- .wrap-narrow -->
    </div><!-- .article__header -->

    <div class="jt-strap">
        <div class="wrap-narrow">
            <div class="jt-strap__inner">
                <div class="jt-strap__content">
                    <h2 class="jt-strap__title jt-typo--09">{!! __('front.mypage.hello', ['NAME'=>$user_name]) !!}</h2>
                    <p class="jt-strap__desc jt-typo--15">{{ $is_guest ? '비회원은 최근 6개월 이내 예약까지만 조회가 가능합니다.' : __('front.mypage.desc') }}</p>
                </div><!-- .jt-strap__content -->

                @if(!$is_guest)
                    <div class="jt-strap__control">
                        <a href="{{ jt_route('member.profile') }}" data-barba-prevent class="jt-btn__basic jt-btn--type-02 jt-btn--small"><span class="jt-typo--16">{!! __('front.mypage.edit') !!}</span></a>
                        <a href="{{ jt_route('logout') }}" data-barba-prevent class="jt-btn__basic jt-btn--type-02 jt-btn--small"><span class="jt-typo--16">{!! __('front.ui.logout') !!}</span></a>
                    </div><!-- .jt-strap__control -->
                @endif
            </div><!-- .jt-strap__inner -->
        </div><!-- .wrap-narrow -->
    </div><!-- .jt-strap -->

    <div class="article__body">

        <div class="article__section article__section--primary">
            <div class="wrap-narrow">

                <div class="jt-search">
                    <form class="jt-search__form" novalidate>
                        <div class="jt-category">
                            <a
                                href="{{ jt_route('member.reservation.list') }}"
                                @class([
                                    'jt-category--current' => 'cancel' !== $filter_status,
                                ])
                            ><span class="jt-typo--10">{!! __('front.mypage.cetegory.complete') !!}</span></a>
                            <a
                                href="{{ jt_route('member.reservation.list', ['status' => 'cancel']) }}"
                                @class([
                                    'jt-category--current' => 'cancel' === $filter_status,
                                ])
                            ><span class="jt-typo--10">{!! __('front.mypage.cetegory.cancelled') !!}</span></a>
                        </div><!-- .jt-category -->

                        <div class="jt-filter">
                            @if('cancel' === $filter_status)
                                <input type="hidden" name="status" value="cancel" />
                            @endif

                            <div class="jt-filter__group">
                                @if('cancel' !== $filter_status)
                                    <div class="jt-checkbox">
                                        <label>
                                            <input type="checkbox" name="filter_used" @checked($filter_used) />
                                            <span>{!! __('front.mypage.filter.unused') !!}</span>
                                        </label>
                                    </div><!-- .jt-checkbox -->
                                @endif
                            </div><!-- .jt-filter__group -->

                            <div class="jt-filter__group">
                                <div class="jt-filter__picker">
                                    <a
                                        href="{{ jt_route('member.reservation.list', [...request()->query(), 'period' => 'all']) }}"
                                        @class([
                                            'jt-filter__picker--current' => empty($filter_period) && empty(request()->query('start_date')) && empty(request()->query('end_date')) || 'all' === $filter_period,
                                        ])
                                    ><span class="jt-typo--15">{!! __('front.ui.all') !!}</span></a>
                                    <a
                                        href="{{ jt_route('member.reservation.list', [...request()->query(), 'period' => 'w']) }}"
                                        @class([
                                            'jt-filter__picker--current' => 'w' === $filter_period,
                                        ])
                                    ><span class="jt-typo--15">{!! __('front.mypage.filter.week') !!}</span></a>
                                    <a
                                        href="{{ jt_route('member.reservation.list', [...request()->query(), 'period' => 'm']) }}"
                                        @class([
                                            'jt-filter__picker--current' => 'm' === $filter_period,
                                        ])
                                    ><span class="jt-typo--15">{!! __('front.mypage.filter.month') !!}</span></a>
                                    <a
                                        href="{{ jt_route('member.reservation.list', [...request()->query(), 'period' => 'y']) }}"
                                        @class([
                                            'jt-filter__picker--current' => 'y' === $filter_period,
                                        ])
                                    ><span class="jt-typo--15">{!! __('front.mypage.filter.year') !!}</span></a>
                                </div><!-- .jt-filter__picker -->

                                <div class="jt-filter__range">
                                    <input type="date" name="start_date" class="jt-search__field jt-search__field--date" required value="{{ $start_date }}" />
                                    <span>~</span>
                                    <input type="date" name="end_date" class="jt-search__field jt-search__field--date" required value="{{ $end_date }}" />
                                </div><!-- .jt-filter__range -->

                                <div class="jt-search__control">
                                    <button type="submit" class="jt-search__action"><span class="jt-typo--15">{!! __('front.mypage.search') !!}</span></button>
                                </div><!-- .jt-search__control -->
                            </div><!-- .jt-filter__group -->
                        </div><!-- .jt-filter__group -->
                    </form><!-- .jt-search__form -->
                </div><!-- .jt-search -->

                @if($reservations->count() > 0)
                    <ul class="jt-reservation__list">
                        @foreach($reservations as $reservation)
                            <li>
                                <div class="jt-reservation__result">
                                    <div class="jt-reservation__result-content">
                                        <div class="jt-reservation__result-content-inner">
                                            <div class="jt-reservation__result-data">
                                                <b class="jt-reservation__result-title jt-typo--06">{{ $reservation->ticket->title[app()->getLocale() === 'en' ? 'en' : 'ko'] }}</b>
                                                <ul class="jt-reservation__result-list">
                                                    <li class="jt-reservation__result--sector">
                                                        <b class="jt-typo--15">{!! __('front.reservation.result.sector') !!}</b>
                                                        <span class="jt-typo--15">{{ $reservation->ticket->sector[app()->getLocale() === 'en' ? 'en' : 'ko'] }}</span>
                                                    </li>
                                                    <li class="jt-reservation__result--date">
                                                        <b class="jt-typo--15">{!! __('front.reservation.result.date') !!}</b>
                                                        <span class="jt-typo--15">{{ 'en' === $locale ? $reservation->select_date->format('l, F j, y') : date_format_korean($reservation->select_date, 'Y년 m월 d일(D)') }}</span>
                                                        
                                                    </li>
                                                    <li class="jt-reservation__result--time">
                                                        <b class="jt-typo--15">{!! __('front.reservation.result.time') !!}</b>
                                                        <span class="jt-typo--15">{{ 'en' === $locale ? $reservation->select_time->format('A h:i') : date_format_korean($reservation->select_time, 'A h:i') }}{{ $reservation->use_docent ? '('.__('front.reservation.result.docent').')' : '' }}</span>
                                                    </li>
                                                    <li class="jt-reservation__result--visitor">
                                                        <b class="jt-typo--15">{!! __('front.reservation.result.visitor') !!}</b>
                                                        <span class="jt-typo--15">{{ $reservation->get_visitors_label() }}</span>
                                                    </li>
                                                    @if(!is_null($reservation->canceled_at))
                                                        <li class="jt-reservation__result--cancel">
                                                            <b class="jt-typo--15">{!! __('front.reservation.result.cancel') !!}</b>
                                                            <span class="jt-typo--15">{{ $reservation->canceled_at->format('Y-m-d H:i:s') }}</span>
                                                        </li>
                                                        <li class="jt-reservation__result--amount">
                                                            <b class="jt-typo--15">{!! __('front.reservation.result.amount') !!}</b>
                                                            <span class="jt-typo--15">{!! __('front.reservation.common.price', ['PRICE'=>number_format($reservation->amount)]) !!}({{ $reservation->get_payment_type() }})</span>
                                                        </li>
                                                    @else
                                                        <li class="jt-reservation__result--payment">
                                                            <b class="jt-typo--15">{!! __('front.reservation.result.payment') !!}</b>
                                                            <span class="jt-typo--15">{{ $reservation->paid_at->format('Y-m-d H:i:s') }}</span>
                                                        </li>
                                                    @endif
                                                </ul><!-- .jt-reservation__result-list -->
                                            </div><!-- .jt-reservation__result-data -->

                                            <div class="jt-reservation__result-last">
                                                <div class="jt-reservation__result-price">
                                                    <b class="jt-typo--15">{{ is_null($reservation->canceled_at) ? __('front.reservation.result.amount') : __('front.reservation.result.refund') }}</b>
                                                    <span class="jt-typo--09">{!! __('front.reservation.common.price', ['PRICE'=>number_format($reservation->canceled_amount ?? $reservation->amount)]) !!}({{ $reservation->get_payment_type() }})</span>
                                                </div><!-- .jt-reservation__result-price -->

                                                <div class="jt-reservation__result-number">
                                                    <b class="jt-typo--15">{!! __('front.reservation.result.number') !!}</b>
                                                    <span class="jt-typo--15">{{ $reservation->code }}</span>
                                                </div><!-- .jt-reservation__result-number -->

                                                <div class="jt-reservation__result-control">
                                                    @if(!is_null($reservation->canceled_at))
                                                        <button class="jt-btn__basic jt-btn--type-01 jt-btn--large jt-btn--disabled" disabled><span class="jt-typo--15">{!! __('front.reservation.result.state.canceled') !!}</span></button>
                                                    @elseif(!is_null($reservation->used_at))
                                                        <button class="jt-btn__basic jt-btn--type-01 jt-btn--large jt-btn--disabled" disabled><span class="jt-typo--15">{!! __('front.reservation.result.state.used') !!}</span></button>
                                                    @elseif($reservation->is_past())
                                                        <button class="jt-btn__basic jt-btn--type-01 jt-btn--large jt-btn--disabled" disabled><span class="jt-typo--15">{!! __('front.reservation.result.state.expired') !!}</span></button>
                                                    @else
                                                        @if($reservation->can_cancel() || $reservation->amount === 0)
                                                            <form
                                                                class="jt-reservation__action--cancel"
                                                                action="{{ jt_route('member.reservation.cancel', compact('reservation')) }}"
                                                                method="POST"
                                                                data-msg="{{ $reservation->get_cancel_message() }}"
                                                            >
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="jt-btn__basic jt-btn--type-03 jt-btn--large"><span class="jt-typo--15">{!! __('front.reservation.result.state.cancel') !!}</span></button>
                                                            </form>
                                                        @endif

                                                        <button class="jt-btn__basic jt-btn--type-01 jt-btn--large jt-reservation__action--useable" data-code="{{ $reservation->code }}"><span class="jt-typo--15">{!! __('front.reservation.result.state.useable') !!}</span></button>
                                                    @endif
                                                </div><!-- .jt-reservation__result-control -->

                                                @if(is_null($reservation->canceled_at))
                                                    <p class="jt-reservation__result-explain">
                                                        <i class="jt-icon">
                                                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path d="M10,1a9,9,0,1,0,9,9A9,9,0,0,0,10,1ZM15,15A7,7,0,1,1,17,10,7,7,0,0,1,15,15Z" />
                                                                <path d="M9 9h2v5H9Z" />
                                                                <path d="M9 7a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                            </svg>
                                                        </i><!-- .jt-icon -->
                                                        <span class="jt-typo--17">{!! __('front.reservation.result.explain') !!}</span>
                                                    </p><!-- .jt-reservation__result-explain -->
                                                @endif
                                            </div><!-- .jt-reservation__result-last -->
                                        </div><!-- .jt-reservation__result-content-inner -->
                                    </div><!-- .jt-reservation__result-content -->
                                </div><!-- .jt-reservation__result-result -->
                            </li>
                        @endforeach
                    </ul><!-- .jt-reservation__list -->

                    {{ $reservations->withQueryString()->links('front.partials.pagination') }}
                @else
                    @include('front.partials.empty', ['title'=>__('front.mypage.empty.title'), 'desc'=>__('front.mypage.empty.desc')])

                    <div class="jt-controls">
                        <a href="{{ jt_route('index') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.go-home') !!}</span></a>
                    </div><!-- .jt-btns -->
                @endif
            </div><!-- .wrap-narrow -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection

@push('popup')
    <div class="reservation-qrcode-popup jt-popup">
        <div class="jt-popup__container">

            <div class="jt-popup__container-inner">
                <div class="reservation-qrcode__container">
                    <div class="reservation-qrcode__header">
                        <i class="jt-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 450 50">
                                <path d="M17.22 26.4L4.43 12.33L0 12.33L0 46.77L4.92 46.77L4.92 20.05L4.92 20.04L17.22 33.38L29.52 20.04L29.52 46.76L34.45 46.76L34.45 12.33L30.02 12.33L17.22 26.4z" />
                                <path d="M53.1 46.76L80.16 46.76L80.16 42.09L58.02 42.09L58.02 31.76L73.53 31.76L73.53 27.08L58.02 27.08L58.02 17L80.16 17L80.16 12.33L53.1 12.33L53.1 46.76z" />
                                <path d="M73.7 0.03L68.05 0.03L63.81 8.88L68.05 8.88L73.7 0.03z" />
                                <path d="M112.85,12.34H98.14V46.78h14.71a17.22,17.22,0,1,0,0-34.44Zm0,29.75h-9.78V17h9.78c6.89,0,12.1,5.41,12.1,12.55S119.76,42.09,112.86,42.09Z" />
                                <path d="M130.08 29.56L130.08 29.55L130.08 29.56L130.08 29.56z" />
                                <path d="M160.93,11.84a17.71,17.71,0,1,0,17.71,17.71A17.8,17.8,0,0,0,160.93,11.84Zm0,30.75c-7.13,0-12.6-5.76-12.6-13s5.47-13,12.6-13,12.59,5.75,12.59,13S168.07,42.59,160.94,42.59Z" />
                                <path d="M219.33 38.6L199.15 12.33L194.48 12.33L194.48 46.76L199.4 46.76L199.4 20.49L219.57 46.76L224.25 46.76L224.25 12.33L219.33 12.33L219.33 38.6z" />
                                <path d="M257.79,31.86h12.59a12.68,12.68,0,0,1-12.59,10.73c-7.13,0-12.6-5.76-12.6-13s5.47-13,12.6-13a11.81,11.81,0,0,1,9,4l3.49-3.49a17.66,17.66,0,1,0,5.22,12.49V27.19H257.79Z" />
                                <path d="M314.9,31.86h0l-8.77-19.53h-5l-15.4,34.43H291l4.53-10.23H311.6l4.53,10.23h5.36L314.9,32Zm-17.31,0,6-13.48,6,13.48Z" />
                                <path d="M358.48,32.45a10,10,0,1,1-19.92,0V12.33h-4.93V32.55a14.89,14.89,0,0,0,29.78,0V12.33h-4.93Z" />
                                <path d="M386.52 12.33L381.59 12.33L381.59 46.76L408.65 46.76L408.65 42.09L386.52 42.09L386.52 12.33z" />
                                <path d="M450 17L450 12.33L422.94 12.33L422.94 46.76L450 46.76L450 42.09L427.86 42.09L427.86 31.76L443.36 31.76L443.36 27.08L427.86 27.08L427.86 17L450 17z" />
                            </svg>
                        </i>
                        <div class="reservation-qrcode__image" id="qr-code"></div>
                        <p class="jt-typo--16">{!! __('front.reservation.qrcode.useable') !!}</p>
                    </div><!-- .reservation-qrcode__header -->

                    <div class="reservation-qrcode__body">
                        <ul class="reservation-qrcode__data">
                            <li class="reservation-qrcode--code">
                                <b class="jt-typo--16">{!! __('front.reservation.result.number') !!}</b>
                                <span class="jt-typo--17"></span>
                            </li>
                            <li class="reservation-qrcode--date">
                                <b class="jt-typo--16">{!! __('front.reservation.result.date') !!}</b>
                                <span class="jt-typo--17"></span>
                            </li>
                            <li class="reservation-qrcode--time">
                                <b class="jt-typo--16">{!! __('front.reservation.result.time') !!}</b>
                                <span class="jt-typo--17"></span>
                            </li>
                            <li class="reservation-qrcode--visitor">
                                <b class="jt-typo--16">{!! __('front.reservation.result.visitor') !!}</b>
                                <span class="jt-typo--17"></span>
                            </li>
                        </ul><!-- .reservation-qrcode__data -->
                    </div><!-- .reservation-qrcode__body -->
                </div><!-- .reservation-qrcode__container -->
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
    </div><!-- .reservation-qrcode-popup -->
@endpush

@push('script')
<script>
    @session('cancel-message')
        JT.confirm('{{ $value }}');
    @endsession

    document.addEventListener('click', (e) => {
        if( !!e.target.closest('.jt-reservation__action--cancel') ){
            const form = e.target.closest('.jt-reservation__action--cancel');

            let msg = form.dataset.msg || '';

            if( msg ){
                if( msg == '{{ __("jt.CA-04") }}' ){
                    JT.confirm(msg);
                } else {
                    JT.confirm({
                        message: msg,
                        isChoice: true,
                        confirm: '{!! __("front.reservation.result.modal.confirm") !!}',
                        cancel: '{!! __("front.reservation.result.modal.cancel") !!}',
                        onConfirm: () => {
                            form.submit();
                        }
                    });
                }
            }
        }
    });
</script>
@endpush
