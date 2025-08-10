@extends('front.partials.layout', [
    'view' => 'reservation-qrcode',
    'seo_title' => __('front.reservation.qrcode.title'),
    'seo_description' => '',
    'hide_layout' => '1'
])

@section('content')

<div class="reservation-qrcode__container">
    @if($reservation && ($reservation->can_use() || $reservation->is_future()))
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
            <div class="reservation-qrcode__image" id="qr-code" data-code="{{ $reservation->code }}"></div>
            <p class="jt-typo--16">{!! __('front.reservation.qrcode.useable') !!}</p>
        </div><!-- .reservation-qrcode__header -->

        <div class="reservation-qrcode__body">
            <ul class="reservation-qrcode__data">
                <li class="reservation-qrcode--code">
                    <b class="jt-typo--16">{!! __('front.reservation.result.number') !!}</b>
                    <span class="jt-typo--17">{{ $reservation->code }}</span>
                </li>
                <li class="reservation-qrcode--date">
                    <b class="jt-typo--16">{!! __('front.reservation.result.date') !!}</b>
                    <span class="jt-typo--17">{{ 'en' === $locale ? $reservation->select_date->format('l, F j, y') : date_format_korean($reservation->select_date, 'Y년 m월 d일(D)') }}</span>
                </li>
                <li class="reservation-qrcode--time">
                    <b class="jt-typo--16">{!! __('front.reservation.result.time') !!}</b>
                    <span class="jt-typo--17">{{ 'en' === $locale ? $reservation->select_time->format('A h:i') : date_format_korean($reservation->select_time, 'A h:i') }}{{ $reservation->use_docent ? '('.__('front.reservation.result.docent').')' : '' }}</span>
                </li>
                <li class="reservation-qrcode--visitor">
                    <b class="jt-typo--16">{!! __('front.reservation.result.visitor') !!}</b>
                    <span class="jt-typo--17">{{ $reservation->get_visitors_label() }}</span>
                </li>
            </ul><!-- .reservation-qrcode__data -->
        </div><!-- .reservation-qrcode__body -->
    @else
        <div class="reservation-qrcode__disabled">
            <div class="reservation-qrcode__info">
                <i class="jt-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                        <path d="M47.5 32.5h5v24.38H47.5Z" />
                        <path d="M46.25 64.38a3.75 3.75 0 1 0 7.5 0a3.75 3.75 0 1 0 -7.5 0" />
                        <path d="M50,7.5A42.5,42.5,0,1,0,92.5,50,42.5,42.5,0,0,0,50,7.5Zm26.52,69A37.52,37.52,0,1,1,87.5,50,37.39,37.39,0,0,1,76.52,76.52Z" />
                    </svg>
                </i><!-- .jt-icon -->
            </div><!-- .reservation-qrcode__info -->
    
            <div class="reservation-qrcode__desc">
                @if(!empty($reservation->used_at))
                    <p class="jt-typo--15">{!! __('front.reservation.qrcode.used') !!}</p>
                @else
                    <p class="jt-typo--15">{!! __('front.reservation.qrcode.impossible') !!}</p>
                @endif
            </div><!-- .reservation-qrcode__desc -->
        </div>
    @endif
</div><!-- .reservation-qrcode__container -->

@endsection
