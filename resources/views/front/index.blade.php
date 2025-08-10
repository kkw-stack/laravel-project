@extends('front.partials.layout', [ 'view' => 'home' ])

@section('content')
<div class="main-visual">
    <div class="main-visual__slider swiper">
        <div class="swiper-wrapper">
            @foreach($visuals as $visual)
                <div
                    @class([
                        'main-visual__slide',
                        'swiper-slide',
                    ])
                >
                    @if($visual->video)
                        <div class="main-visual__slide-video main-visual__slide--desktop">
                            <div class="jt-background-video">
                                <div class="jt-background-video__vod">
                                    <video playsinline muted preload>
                                        <source src="{{ $visual->video }}" type="video/mp4" />
                                    </video>
                                </div><!-- .jt-background-video__vod -->

                                <div class="jt-background-video__poster swiper-lazy" data-background="{{ Storage::url($visual->thumbnail) }}" style="background-image: url(/assets/front/images/layout/blank.gif);">
                                    <div class="jt-background-video__error">
                                        <i class="jt-icon">
                                            <svg width="72" height="72" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M54.7808 38.674C56.4908 37.534 56.4908 35.0214 54.7808 33.8814L24.6374 13.7858C22.7235 12.5099 20.1599 13.8819 20.1599 16.1821V56.3733C20.1599 58.6735 22.7235 60.0456 24.6374 58.7696L54.7808 38.674Z" />
                                            </svg>
                                        </i><!-- .jt-icon -->
                                    </div><!-- .jt-background-video__error -->
                                </div><!-- .jt-background-video__poster -->
                            </div><!-- .jt-background-video -->
                        </div><!-- .main-visual__slide-video -->
                    @else
                        <div class="main-visual__slide-bg main-visual__slide--desktop swiper-lazy" data-background="{{ Storage::url($visual->thumbnail) }}" style="background-image: url(/assets/front/images/layout/blank.gif);"></div>
                    @endif

                    @if($visual->video_mobile)
                        <div class="main-visual__slide-video main-visual__slide--mobile">
                            <div class="jt-background-video">
                                <div class="jt-background-video__vod">
                                    <video playsinline muted preload>
                                        <source src="{{ $visual->video_mobile ?? $visual->video }}" type="video/mp4" />
                                    </video>
                                </div><!-- .jt-background-video__vod -->

                                <div class="jt-background-video__poster swiper-lazy" data-background="{{ Storage::url($visual->thumbnail_mobile ?? $visual->thumbnail) }}" style="background-image: url(/assets/front/images/layout/blank.gif);">
                                    <div class="jt-background-video__error">
                                        <i class="jt-icon">
                                            <svg width="72" height="72" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M54.7808 38.674C56.4908 37.534 56.4908 35.0214 54.7808 33.8814L24.6374 13.7858C22.7235 12.5099 20.1599 13.8819 20.1599 16.1821V56.3733C20.1599 58.6735 22.7235 60.0456 24.6374 58.7696L54.7808 38.674Z" />
                                            </svg>
                                        </i><!-- .jt-icon -->
                                    </div><!-- .jt-background-video__error -->
                                </div><!-- .jt-background-video__poster -->
                            </div><!-- .jt-background-video -->
                        </div><!-- .main-visual__slide-video -->
                    @else
                        <div class="main-visual__slide-bg main-visual__slide--mobile swiper-lazy" data-background="{{ Storage::url($visual->thumbnail_mobile ?? $visual->thumbnail) }}" style="background-image: url(/assets/front/images/layout/blank.gif);"></div>
                    @endif
                </div><!-- .main-visual__slide -->
            @endforeach
        </div><!-- .swiper-wrapper -->

        <div class="main-visual__overlay"></div>

        <div class="main-visual__weather">
            <div class="main-visual__weather-item">
                <b class="main-visual__weather-label jt-typo--16">Date</b>
                <p class="main-visual__weather-value">
                    <span class="jt-typo--13">{{ $currentDate }}</span>
                </p><!-- .main-visual__weather-value -->
            </div><!-- .main-visual__weather-item -->
            
            <div class="main-visual__weather-item">
                <b class="main-visual__weather-label jt-typo--16">Location</b>
                <p class="main-visual__weather-value">
                    <span class="jt-typo--13">{{ app()->getLocale() === 'ko' ? '경기도 양평군' : 'Yangpyeong-gun, Gyeonggi-do' }}</span>
                </p><!-- .main-visual__weather-value -->
            </div><!-- .main-visual__weather-item -->
            
            <div class="main-visual__weather-item">
                <b class="main-visual__weather-label jt-typo--16">Weather</b>
                <p class="main-visual__weather-value">
                    <span class="jt-typo--13">
                        {{ isset($weatherData['temperature']) ? $weatherData['temperature'] . '℃' : '-' }}
                    </span>

                    @switch($weatherData['weather_type'])
                        @case('sunny')
                            {{-- 맑음 --}}
                            <i class="jt-icon">
                                <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                    <path d="M15,3h0a1,1,0,0,1,1,1V6a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1V4A1,1,0,0,1,15,3Z"/>
                                    <path d="M15,23h0a1,1,0,0,1,1,1v2a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1V24A1,1,0,0,1,15,23Z"/>
                                    <path d="M23.48,6.51h0a1,1,0,0,1,0,1.42L22.07,9.34a1,1,0,0,1-1.41,0h0a1,1,0,0,1,0-1.41l1.41-1.42A1,1,0,0,1,23.48,6.51Z"/>
                                    <path d="M9.34,20.66h0a1,1,0,0,1,0,1.41L7.93,23.48a1,1,0,0,1-1.42,0h0a1,1,0,0,1,0-1.41l1.42-1.41A1,1,0,0,1,9.34,20.66Z"/>
                                    <path d="M27,15h0a1,1,0,0,1-1,1H24a1,1,0,0,1-1-1h0a1,1,0,0,1,1-1h2A1,1,0,0,1,27,15Z"/>
                                    <path d="M7,15H7a1,1,0,0,1-1,1H4a1,1,0,0,1-1-1H3a1,1,0,0,1,1-1H6A1,1,0,0,1,7,15Z"/>
                                    <path d="M23.48,23.48h0a1,1,0,0,1-1.41,0l-1.41-1.41a1,1,0,0,1,0-1.41h0a1,1,0,0,1,1.41,0l1.41,1.41A1,1,0,0,1,23.48,23.48Z"/>
                                    <path d="M9.34,9.34h0a1,1,0,0,1-1.41,0L6.51,7.93a1,1,0,0,1,0-1.42h0a1,1,0,0,1,1.42,0L9.34,7.93A1,1,0,0,1,9.34,9.34Z"/>
                                    <path d="M15,8a7,7,0,1,0,7,7A7,7,0,0,0,15,8Zm3.54,10.54A5,5,0,1,1,20,15,5,5,0,0,1,18.54,18.54Z"/>
                                </svg>
                            </i>
                            @break
                        @case('cloudy')
                            {{-- 구름많음 --}}
                            <i class="jt-icon">
                                <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                    <path d="M5.6,18h0M13.1,7.05a6,6,0,0,1,1.36,1.29h0A6,6,0,0,0,13.1,7.05M6.51,6.91A5.94,5.94,0,0,0,4.37,9.22a4.54,4.54,0,0,0-2,1.08,4.54,4.54,0,0,1,2-1.08A6,6,0,0,1,6.51,6.91" fill="#fff" />
                                    <path d="M3,13.54A2.46,2.46,0,0,0,5.46,16h0A2.46,2.46,0,0,1,3,13.54M5.19,11.1a2.5,2.5,0,0,0-1.38.62,2.5,2.5,0,0,1,1.38-.62M7.63,8.57A4.07,4.07,0,0,0,6,10.34a1,1,0,0,1-.73.73A1,1,0,0,0,6,10.35,4.09,4.09,0,0,1,7.63,8.57" fill="#fff" />
                                    <path d="M14.95 9.07L14.08 9.56L14.08 9.56L14.95 9.07" />
                                    <path d="M14.46 8.34L14.46 8.34L14.47 8.34L14.46 8.34z" />
                                    <path d="M26.73,15.33a4.33,4.33,0,0,0-3-1.31,7.55,7.55,0,0,0-2.12-4,7.15,7.15,0,0,0-5-2.05,7,7,0,0,0-2.15.35h0A6,6,0,0,0,13.1,7.05,6,6,0,0,0,4.37,9.22a4.54,4.54,0,0,0-2,1.08A4.46,4.46,0,0,0,5.47,18h.58a5.57,5.57,0,0,0,1.5,3.38A5.27,5.27,0,0,0,11.34,23H23.69A4.44,4.44,0,0,0,28,18.5,4.55,4.55,0,0,0,26.73,15.33ZM5.7,16H5.46a2.46,2.46,0,0,1-1.65-4.28,2.5,2.5,0,0,1,1.38-.62h0l.12,0A1,1,0,0,0,6,10.34,4,4,0,0,1,9.69,8h0a4,4,0,0,1,2.91,1.25h0a7.48,7.48,0,0,0-2.49,2.91A5.41,5.41,0,0,0,6.22,16H5.7Zm2.58.12s0,0,0,.05,0,0,0-.05ZM23.66,21H11.71l-.09,0-.24,0h0A3.24,3.24,0,0,1,9,20,3.57,3.57,0,0,1,8,17.5a3.7,3.7,0,0,1,.07-.66s0,.05,0,.07,0,0,0-.07h0l0-.13c0-.06,0-.11,0-.16a3.39,3.39,0,0,1,.15-.45A3.36,3.36,0,0,1,11,14a1,1,0,0,0,.83-.71A5.48,5.48,0,0,1,13.65,11a5.3,5.3,0,0,1,.79-.47l.24-.1a6.26,6.26,0,0,1,.61-.21A4.86,4.86,0,0,1,16.62,10a5.15,5.15,0,0,1,3.6,1.48,5.6,5.6,0,0,1,1.66,3.67,1,1,0,0,0,.4.74,1,1,0,0,0,.83.17,2.75,2.75,0,0,1,.52-.06,2.33,2.33,0,0,1,1.66.72A2.53,2.53,0,0,1,26,18.5,2.43,2.43,0,0,1,23.66,21Z" />
                                </svg>
                            </i>
                            @break
                        @case('overcast')
                            {{-- 흐림 --}}
                            <i class="jt-icon">
                                <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                    <path d="M22.32,13.37a7.87,7.87,0,0,0-14.8-2A5.76,5.76,0,0,0,8.77,22.79H22.35a4.71,4.71,0,0,0,0-9.42Zm0,7.42H9.18l-.1,0H8.77a3.77,3.77,0,0,1-.43-7.52,1,1,0,0,0,.83-.71,5.89,5.89,0,0,1,11.29,2,1,1,0,0,0,.4.74,1,1,0,0,0,.83.17,2.68,2.68,0,0,1,.59-.06,2.71,2.71,0,0,1,0,5.42Z"/>
                                </svg>
                            </i>
                            @break
                        @case('rain')
                            {{-- 비 --}}
                            <i class="jt-icon">
                                <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                    <path d="M22.32,10.37a7.87,7.87,0,0,0-14.8-2A5.76,5.76,0,0,0,8.77,19.79H22.35a4.71,4.71,0,0,0,0-9.42Zm0,7.42H9.18l-.1,0H8.77a3.77,3.77,0,0,1-.43-7.52,1,1,0,0,0,.83-.71,5.89,5.89,0,0,1,11.29,2,1,1,0,0,0,.4.74,1,1,0,0,0,.83.17,2.68,2.68,0,0,1,.59-.06,2.71,2.71,0,0,1,0,5.42Z"/>
                                    <path d="M8.29,21.55l-3,3A1,1,0,0,0,6.71,26l3-3a1,1,0,1,0-1.42-1.42"/>
                                    <path d="M14.29,21.55l-3,3A1,1,0,0,0,12.71,26l3-3a1,1,0,1,0-1.42-1.42"/>
                                    <path d="M20.29,21.55l-3,3A1,1,0,0,0,18.71,26l3-3a1,1,0,1,0-1.42-1.42"/>
                                </svg>                                
                            </i>
                            @break
                        @case('rain-snow')
                            {{-- 비/눈 --}}
                            <i class="jt-icon">
                                <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                    <path d="M11.91,23.53,11.12,25a1,1,0,0,0,1.76.94l.79-1.47a1,1,0,0,0-1.76-.94"/>
                                    <path d="M5.91,23.53,5.12,25a1,1,0,0,0,1.76.94l.79-1.47a1,1,0,0,0-1.76-.94"/>
                                    <path d="M17.91,23.53,17.12,25a1,1,0,0,0,1.76.94l.79-1.47a1,1,0,0,0-1.76-.94"/>
                                    <path d="M26.85,13.66l-1.49-.39a.77.77,0,0,0-.5,1.46l.14,0,1.49.39a.77.77,0,0,0,.39-1.49Z"/>
                                    <path d="M23.38,19.93a1.19,1.19,0,0,1-.15.18A.65.65,0,0,0,23.38,19.93Z"/>
                                    <path d="M14.33,6.63A.77.77,0,1,0,15.71,6l-.05-.09-.77-1.33a.77.77,0,0,0-1.33.77Z"/>
                                    <path d="M20.05,6.28A.78.78,0,0,0,21,5.74h0l.39-1.49a.77.77,0,0,0-1.49-.39h0l-.4,1.49a.77.77,0,0,0,.55.94Z"/>
                                    <path d="M24.85,9.42l1.33-.77a.77.77,0,0,0-.77-1.33l-1.33.77a.77.77,0,1,0,.68,1.38Z"/>
                                    <path d="M23.29,15.11a5.51,5.51,0,0,0,.8-2.88A5.62,5.62,0,0,0,14.74,8a7.21,7.21,0,0,0-1.54-.19A7,7,0,0,0,7,11.67,5.12,5.12,0,0,0,8.15,21.78H19.94a4.21,4.21,0,0,0,3.29-1.67,1.19,1.19,0,0,0,.15-.18A4.13,4.13,0,0,0,23.29,15.11Zm-4.82-6.5a3.6,3.6,0,0,1,3.25,5.19A4.28,4.28,0,0,0,20,13.37,7,7,0,0,0,17,9,3.78,3.78,0,0,1,18.47,8.61Zm1.45,11.17H8.17a3.13,3.13,0,0,1-.37-6.24,1.23,1.23,0,0,0,.37-.12,1.09,1.09,0,0,0,.17-.13l.08-.07a1.14,1.14,0,0,0,.23-.38,5,5,0,0,1,3.7-2.91,4.31,4.31,0,0,1,.88-.09h.18a4.77,4.77,0,0,1,2,.5,5,5,0,0,1,2.8,4.14,1,1,0,0,0,.4.74,1,1,0,0,0,.81.18,2.07,2.07,0,0,1,.5-.06h.31a2.2,2.2,0,0,1,1.71,1.28,2.28,2.28,0,0,1,.19.81v.09a2.23,2.23,0,0,1-2.19,2.21Z"/>
                                </svg>
                            </i>
                            @break
                        @case('snow')
                            {{-- 눈 --}}
                            <i class="jt-icon">
                                <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                    <path d="M24.33,19.13l-1.81-1,1.77-.47a1,1,0,0,0,.7-1.23,1,1,0,0,0-1.22-.7l-3.7,1L17.17,15l2.9-1.67,3.7,1a1,1,0,0,0,.51-1.94l-1.76-.47,1.8-1a1,1,0,1,0-1-1.73l-1.8,1L22,8.41a1,1,0,1,0-1.93-.51l-1,3.69-2.91,1.68V9.92l2.71-2.71a1,1,0,0,0,0-1.41,1,1,0,0,0-1.42,0L16.16,7.09V5a1,1,0,0,0-2,0V7.09L12.87,5.8a1,1,0,0,0-1.42,0,1,1,0,0,0,0,1.41l2.71,2.71v3.34l-2.9-1.67-1-3.7a1,1,0,1,0-1.93.52l.47,1.77L7,9.13a1,1,0,0,0-1,1.74l1.81,1L6,12.38a1,1,0,0,0,.52,1.93l3.7-1L13.17,15l-2.91,1.68-3.7-1A1,1,0,0,0,6,17.62l1.77.47L6,19.14a1,1,0,0,0,1,1.73l1.81-1-.47,1.76A1,1,0,0,0,9,22.82a1,1,0,0,0,1.23-.71l1-3.7,2.9-1.67v3.35L11.45,22.8a1,1,0,0,0,0,1.41,1,1,0,0,0,1.42,0l1.29-1.29V25a1,1,0,0,0,2,0V22.92l1.29,1.29a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.41l-2.71-2.71V16.73l2.91,1.68,1,3.7A1,1,0,0,0,22,21.59l-.47-1.77,1.81,1.05a1,1,0,0,0,1-1.74Z"/>
                                </svg>
                            </i>
                            @break
                        @case('shower')
                            {{-- 소나기 --}}
                            <i class="jt-icon">
                                <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                    <path d="M24.73,11.38a4.3,4.3,0,0,0-3-1.32,7.59,7.59,0,0,0-2.12-4A7.14,7.14,0,0,0,8.12,8.22,5.45,5.45,0,0,0,4,13.55a5.56,5.56,0,0,0,1.55,3.87,5.26,5.26,0,0,0,3.79,1.63H21.69A4.43,4.43,0,0,0,26,14.55,4.53,4.53,0,0,0,24.73,11.38Zm-3.08,5.67H9.72l-.1,0-.24,0h0A3.24,3.24,0,0,1,7,16a3.58,3.58,0,0,1-1-2.49,3.45,3.45,0,0,1,3-3.48,1,1,0,0,0,.84-.73A5.25,5.25,0,0,1,14.62,6a5.12,5.12,0,0,1,3.6,1.49,5.56,5.56,0,0,1,1.66,3.66,1,1,0,0,0,1.24.91,2.3,2.3,0,0,1,.51,0,2.27,2.27,0,0,1,1.66.72A2.52,2.52,0,0,1,24,14.55,2.43,2.43,0,0,1,21.65,17.05Z"/>
                                    <path d="M20.49,20.37a1,1,0,0,0-1.29.57l-.63,1.64a1,1,0,1,0,1.86.72l.63-1.64A1,1,0,0,0,20.49,20.37Z"/>
                                    <path d="M9,20.37a1,1,0,0,0-1.29.57l-.63,1.64A1,1,0,1,0,9,23.3l.63-1.64A1,1,0,0,0,9,20.37Z"/>
                                    <path d="M15.18,23.31l-1-.59.54-.91a1,1,0,0,0-1.72-1l-1,1.76a1,1,0,0,0,.35,1.37l.93.56-.79,1.14a1,1,0,1,0,1.64,1.14l1.4-2a1,1,0,0,0,.16-.78A1,1,0,0,0,15.18,23.31Z"/>
                                </svg>                                
                            </i>
                            @break
                        @default
                    @endswitch
                </p><!-- .main-visual__weather-value -->
            </div><!-- .main-visual__weather-item -->
            
            <div class="main-visual__weather-item">
                <b class="main-visual__weather-label jt-typo--16">Fine Dust</b>
                <p class="main-visual__weather-value">
                    <span class="jt-typo--13">
                        @if(!empty($weatherData->air_quality) && isset($weatherData['pm10']))
                            {{ $weatherData->air_quality }} {{ $weatherData['pm10'] }}㎍/m³
                        @else
                            -
                        @endif
                    </span>
                </p><!-- .main-visual__weather-value -->
            </div><!-- .main-visual__weather-item -->

            <div class="main-visual__weather-mobile">
                <div class="main-visual__weather-row">
                    <p class="jt-typo--17">{{ $currentDate }}, {{ app()->getLocale() === 'ko' ? '경기도 양평군' : 'Yangpyeong-gun, Gyeonggi-do' }}</p>
                </div><!-- .main-visual__weather-row -->
                <div class="main-visual__weather-row">
                    <div class="main-visual__weather-temp">
                        @switch($weatherData['weather_type'])
                            @case('sunny')
                                {{-- 맑음 --}}
                                <i class="jt-icon">
                                    <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                        <path d="M15,3h0a1,1,0,0,1,1,1V6a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1V4A1,1,0,0,1,15,3Z"/>
                                        <path d="M15,23h0a1,1,0,0,1,1,1v2a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1V24A1,1,0,0,1,15,23Z"/>
                                        <path d="M23.48,6.51h0a1,1,0,0,1,0,1.42L22.07,9.34a1,1,0,0,1-1.41,0h0a1,1,0,0,1,0-1.41l1.41-1.42A1,1,0,0,1,23.48,6.51Z"/>
                                        <path d="M9.34,20.66h0a1,1,0,0,1,0,1.41L7.93,23.48a1,1,0,0,1-1.42,0h0a1,1,0,0,1,0-1.41l1.42-1.41A1,1,0,0,1,9.34,20.66Z"/>
                                        <path d="M27,15h0a1,1,0,0,1-1,1H24a1,1,0,0,1-1-1h0a1,1,0,0,1,1-1h2A1,1,0,0,1,27,15Z"/>
                                        <path d="M7,15H7a1,1,0,0,1-1,1H4a1,1,0,0,1-1-1H3a1,1,0,0,1,1-1H6A1,1,0,0,1,7,15Z"/>
                                        <path d="M23.48,23.48h0a1,1,0,0,1-1.41,0l-1.41-1.41a1,1,0,0,1,0-1.41h0a1,1,0,0,1,1.41,0l1.41,1.41A1,1,0,0,1,23.48,23.48Z"/>
                                        <path d="M9.34,9.34h0a1,1,0,0,1-1.41,0L6.51,7.93a1,1,0,0,1,0-1.42h0a1,1,0,0,1,1.42,0L9.34,7.93A1,1,0,0,1,9.34,9.34Z"/>
                                        <path d="M15,8a7,7,0,1,0,7,7A7,7,0,0,0,15,8Zm3.54,10.54A5,5,0,1,1,20,15,5,5,0,0,1,18.54,18.54Z"/>
                                    </svg>
                                </i>
                                @break
                            @case('cloudy')
                                {{-- 구름많음 --}}
                                <i class="jt-icon">
                                    <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                        <path d="M5.6,18h0M13.1,7.05a6,6,0,0,1,1.36,1.29h0A6,6,0,0,0,13.1,7.05M6.51,6.91A5.94,5.94,0,0,0,4.37,9.22a4.54,4.54,0,0,0-2,1.08,4.54,4.54,0,0,1,2-1.08A6,6,0,0,1,6.51,6.91" fill="#fff" />
                                        <path d="M3,13.54A2.46,2.46,0,0,0,5.46,16h0A2.46,2.46,0,0,1,3,13.54M5.19,11.1a2.5,2.5,0,0,0-1.38.62,2.5,2.5,0,0,1,1.38-.62M7.63,8.57A4.07,4.07,0,0,0,6,10.34a1,1,0,0,1-.73.73A1,1,0,0,0,6,10.35,4.09,4.09,0,0,1,7.63,8.57" fill="#fff" />
                                        <path d="M14.95 9.07L14.08 9.56L14.08 9.56L14.95 9.07" />
                                        <path d="M14.46 8.34L14.46 8.34L14.47 8.34L14.46 8.34z" />
                                        <path d="M26.73,15.33a4.33,4.33,0,0,0-3-1.31,7.55,7.55,0,0,0-2.12-4,7.15,7.15,0,0,0-5-2.05,7,7,0,0,0-2.15.35h0A6,6,0,0,0,13.1,7.05,6,6,0,0,0,4.37,9.22a4.54,4.54,0,0,0-2,1.08A4.46,4.46,0,0,0,5.47,18h.58a5.57,5.57,0,0,0,1.5,3.38A5.27,5.27,0,0,0,11.34,23H23.69A4.44,4.44,0,0,0,28,18.5,4.55,4.55,0,0,0,26.73,15.33ZM5.7,16H5.46a2.46,2.46,0,0,1-1.65-4.28,2.5,2.5,0,0,1,1.38-.62h0l.12,0A1,1,0,0,0,6,10.34,4,4,0,0,1,9.69,8h0a4,4,0,0,1,2.91,1.25h0a7.48,7.48,0,0,0-2.49,2.91A5.41,5.41,0,0,0,6.22,16H5.7Zm2.58.12s0,0,0,.05,0,0,0-.05ZM23.66,21H11.71l-.09,0-.24,0h0A3.24,3.24,0,0,1,9,20,3.57,3.57,0,0,1,8,17.5a3.7,3.7,0,0,1,.07-.66s0,.05,0,.07,0,0,0-.07h0l0-.13c0-.06,0-.11,0-.16a3.39,3.39,0,0,1,.15-.45A3.36,3.36,0,0,1,11,14a1,1,0,0,0,.83-.71A5.48,5.48,0,0,1,13.65,11a5.3,5.3,0,0,1,.79-.47l.24-.1a6.26,6.26,0,0,1,.61-.21A4.86,4.86,0,0,1,16.62,10a5.15,5.15,0,0,1,3.6,1.48,5.6,5.6,0,0,1,1.66,3.67,1,1,0,0,0,.4.74,1,1,0,0,0,.83.17,2.75,2.75,0,0,1,.52-.06,2.33,2.33,0,0,1,1.66.72A2.53,2.53,0,0,1,26,18.5,2.43,2.43,0,0,1,23.66,21Z" />
                                    </svg>
                                </i>
                                @break
                            @case('overcast')
                                {{-- 흐림 --}}
                                <i class="jt-icon">
                                    <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                        <path d="M22.32,13.37a7.87,7.87,0,0,0-14.8-2A5.76,5.76,0,0,0,8.77,22.79H22.35a4.71,4.71,0,0,0,0-9.42Zm0,7.42H9.18l-.1,0H8.77a3.77,3.77,0,0,1-.43-7.52,1,1,0,0,0,.83-.71,5.89,5.89,0,0,1,11.29,2,1,1,0,0,0,.4.74,1,1,0,0,0,.83.17,2.68,2.68,0,0,1,.59-.06,2.71,2.71,0,0,1,0,5.42Z"/>
                                    </svg>
                                </i>
                                @break
                            @case('rain')
                                {{-- 비 --}}
                                <i class="jt-icon">
                                    <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                        <path d="M22.32,10.37a7.87,7.87,0,0,0-14.8-2A5.76,5.76,0,0,0,8.77,19.79H22.35a4.71,4.71,0,0,0,0-9.42Zm0,7.42H9.18l-.1,0H8.77a3.77,3.77,0,0,1-.43-7.52,1,1,0,0,0,.83-.71,5.89,5.89,0,0,1,11.29,2,1,1,0,0,0,.4.74,1,1,0,0,0,.83.17,2.68,2.68,0,0,1,.59-.06,2.71,2.71,0,0,1,0,5.42Z"/>
                                        <path d="M8.29,21.55l-3,3A1,1,0,0,0,6.71,26l3-3a1,1,0,1,0-1.42-1.42"/>
                                        <path d="M14.29,21.55l-3,3A1,1,0,0,0,12.71,26l3-3a1,1,0,1,0-1.42-1.42"/>
                                        <path d="M20.29,21.55l-3,3A1,1,0,0,0,18.71,26l3-3a1,1,0,1,0-1.42-1.42"/>
                                    </svg>                                
                                </i>
                                @break
                            @case('rain-snow')
                                {{-- 비/눈 --}}
                                <i class="jt-icon">
                                    <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                        <path d="M11.91,23.53,11.12,25a1,1,0,0,0,1.76.94l.79-1.47a1,1,0,0,0-1.76-.94"/>
                                        <path d="M5.91,23.53,5.12,25a1,1,0,0,0,1.76.94l.79-1.47a1,1,0,0,0-1.76-.94"/>
                                        <path d="M17.91,23.53,17.12,25a1,1,0,0,0,1.76.94l.79-1.47a1,1,0,0,0-1.76-.94"/>
                                        <path d="M26.85,13.66l-1.49-.39a.77.77,0,0,0-.5,1.46l.14,0,1.49.39a.77.77,0,0,0,.39-1.49Z"/>
                                        <path d="M23.38,19.93a1.19,1.19,0,0,1-.15.18A.65.65,0,0,0,23.38,19.93Z"/>
                                        <path d="M14.33,6.63A.77.77,0,1,0,15.71,6l-.05-.09-.77-1.33a.77.77,0,0,0-1.33.77Z"/>
                                        <path d="M20.05,6.28A.78.78,0,0,0,21,5.74h0l.39-1.49a.77.77,0,0,0-1.49-.39h0l-.4,1.49a.77.77,0,0,0,.55.94Z"/>
                                        <path d="M24.85,9.42l1.33-.77a.77.77,0,0,0-.77-1.33l-1.33.77a.77.77,0,1,0,.68,1.38Z"/>
                                        <path d="M23.29,15.11a5.51,5.51,0,0,0,.8-2.88A5.62,5.62,0,0,0,14.74,8a7.21,7.21,0,0,0-1.54-.19A7,7,0,0,0,7,11.67,5.12,5.12,0,0,0,8.15,21.78H19.94a4.21,4.21,0,0,0,3.29-1.67,1.19,1.19,0,0,0,.15-.18A4.13,4.13,0,0,0,23.29,15.11Zm-4.82-6.5a3.6,3.6,0,0,1,3.25,5.19A4.28,4.28,0,0,0,20,13.37,7,7,0,0,0,17,9,3.78,3.78,0,0,1,18.47,8.61Zm1.45,11.17H8.17a3.13,3.13,0,0,1-.37-6.24,1.23,1.23,0,0,0,.37-.12,1.09,1.09,0,0,0,.17-.13l.08-.07a1.14,1.14,0,0,0,.23-.38,5,5,0,0,1,3.7-2.91,4.31,4.31,0,0,1,.88-.09h.18a4.77,4.77,0,0,1,2,.5,5,5,0,0,1,2.8,4.14,1,1,0,0,0,.4.74,1,1,0,0,0,.81.18,2.07,2.07,0,0,1,.5-.06h.31a2.2,2.2,0,0,1,1.71,1.28,2.28,2.28,0,0,1,.19.81v.09a2.23,2.23,0,0,1-2.19,2.21Z"/>
                                    </svg>
                                </i>
                                @break
                            @case('snow')
                                {{-- 눈 --}}
                                <i class="jt-icon">
                                    <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                        <path d="M24.33,19.13l-1.81-1,1.77-.47a1,1,0,0,0,.7-1.23,1,1,0,0,0-1.22-.7l-3.7,1L17.17,15l2.9-1.67,3.7,1a1,1,0,0,0,.51-1.94l-1.76-.47,1.8-1a1,1,0,1,0-1-1.73l-1.8,1L22,8.41a1,1,0,1,0-1.93-.51l-1,3.69-2.91,1.68V9.92l2.71-2.71a1,1,0,0,0,0-1.41,1,1,0,0,0-1.42,0L16.16,7.09V5a1,1,0,0,0-2,0V7.09L12.87,5.8a1,1,0,0,0-1.42,0,1,1,0,0,0,0,1.41l2.71,2.71v3.34l-2.9-1.67-1-3.7a1,1,0,1,0-1.93.52l.47,1.77L7,9.13a1,1,0,0,0-1,1.74l1.81,1L6,12.38a1,1,0,0,0,.52,1.93l3.7-1L13.17,15l-2.91,1.68-3.7-1A1,1,0,0,0,6,17.62l1.77.47L6,19.14a1,1,0,0,0,1,1.73l1.81-1-.47,1.76A1,1,0,0,0,9,22.82a1,1,0,0,0,1.23-.71l1-3.7,2.9-1.67v3.35L11.45,22.8a1,1,0,0,0,0,1.41,1,1,0,0,0,1.42,0l1.29-1.29V25a1,1,0,0,0,2,0V22.92l1.29,1.29a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.41l-2.71-2.71V16.73l2.91,1.68,1,3.7A1,1,0,0,0,22,21.59l-.47-1.77,1.81,1.05a1,1,0,0,0,1-1.74Z"/>
                                    </svg>
                                </i>
                                @break
                            @case('shower')
                                {{-- 소나기 --}}
                                <i class="jt-icon">
                                    <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                        <path d="M24.73,11.38a4.3,4.3,0,0,0-3-1.32,7.59,7.59,0,0,0-2.12-4A7.14,7.14,0,0,0,8.12,8.22,5.45,5.45,0,0,0,4,13.55a5.56,5.56,0,0,0,1.55,3.87,5.26,5.26,0,0,0,3.79,1.63H21.69A4.43,4.43,0,0,0,26,14.55,4.53,4.53,0,0,0,24.73,11.38Zm-3.08,5.67H9.72l-.1,0-.24,0h0A3.24,3.24,0,0,1,7,16a3.58,3.58,0,0,1-1-2.49,3.45,3.45,0,0,1,3-3.48,1,1,0,0,0,.84-.73A5.25,5.25,0,0,1,14.62,6a5.12,5.12,0,0,1,3.6,1.49,5.56,5.56,0,0,1,1.66,3.66,1,1,0,0,0,1.24.91,2.3,2.3,0,0,1,.51,0,2.27,2.27,0,0,1,1.66.72A2.52,2.52,0,0,1,24,14.55,2.43,2.43,0,0,1,21.65,17.05Z"/>
                                        <path d="M20.49,20.37a1,1,0,0,0-1.29.57l-.63,1.64a1,1,0,1,0,1.86.72l.63-1.64A1,1,0,0,0,20.49,20.37Z"/>
                                        <path d="M9,20.37a1,1,0,0,0-1.29.57l-.63,1.64A1,1,0,1,0,9,23.3l.63-1.64A1,1,0,0,0,9,20.37Z"/>
                                        <path d="M15.18,23.31l-1-.59.54-.91a1,1,0,0,0-1.72-1l-1,1.76a1,1,0,0,0,.35,1.37l.93.56-.79,1.14a1,1,0,1,0,1.64,1.14l1.4-2a1,1,0,0,0,.16-.78A1,1,0,0,0,15.18,23.31Z"/>
                                    </svg>                                
                                </i>
                                @break
                            @default
                        @endswitch

                        <span class="jt-typo--12">{{ isset($weatherData['temperature']) ? $weatherData['temperature'] . '℃' : '-' }}</span>
                    </div><!-- .main-visual__weather-temp -->

                    <div class="main-visual__weather-dust">
                        <p class="jt-typo--12">
                            {{ app()->getLocale() === 'ko' ? '미세먼지' : 'Fine Dust' }}
                            @if(!empty($weatherData->air_quality) && isset($weatherData['pm10']))
                                {{ $weatherData->air_quality }} {{ $weatherData['pm10'] }}㎍/m³
                            @else
                                -
                            @endif
                        </p>
                    </div><!-- .main-visual__weather-dust -->
                </div><!-- .main-visual__weather-row -->
            </div><!-- .main-visual__weather-mobile -->
        </div><!-- .main-visual__weather -->

        <div class="swiper-controls">
            <div class="swiper-button swiper-button-prev">
                <i class="jt-icon">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M14.4,16.3,8.11,9.92l6.28-6.21A1,1,0,1,0,13,2.29L5.28,9.9,13,17.7a1,1,0,1,0,1.42-1.4Z"/>
                    </svg>
                </i><!-- .jt-icon -->
                <span class="sr-only">{!! __('front.ui.prev') !!}</span>
            </div><!-- .swiper-button-prev -->

            <div class="swiper-pagination"></div>

            <div class="swiper-button swiper-button-next">
                <i class="jt-icon">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M8.4,17.7l7.71-7.8L8.39,2.29A1,1,0,0,0,7,3.71l6.29,6.21L7,16.3A1,1,0,0,0,8.4,17.7Z"/>
                    </svg>
                </i><!-- .jt-icon -->
                <span class="sr-only">{!! __('front.ui.next') !!}</span>
            </div><!-- .swiper-button-next -->
        </div><!-- .swiper-controls -->

        <div class="main-visual__identity">
            <i class="main-visual__identity-logo">
                <svg width="200" height="240" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 240">
                    <path d="M7.65 230.72L1.96 224.47L0 224.47L0 239.78L2.19 239.78L2.19 227.91L7.65 233.84L13.11 227.91L13.11 239.78L15.3 239.78L15.3 224.47L13.34 224.47L7.65 230.72z" />
                    <path d="M23.61 239.78L35.63 239.78L35.63 237.71L25.79 237.71L25.79 233.12L32.68 233.12L32.68 231.05L25.79 231.05L25.79 226.56L35.63 226.56L35.63 224.49L35.63 224.47L23.61 224.47L23.61 239.78z" />
                    <path d="M30.24 219.01L28.36 222.95L30.24 222.95L32.75 219.01L30.24 219.01z" />
                    <path d="M50.17,224.47H43.63v15.31h6.54a7.65,7.65,0,0,0,7.64-7.65h0A7.65,7.65,0,0,0,50.17,224.47Zm0,13.23H45.82V226.55h4.35a5.58,5.58,0,0,1,0,11.15Z" />
                    <path d="M71.53,224.26a7.88,7.88,0,1,0,7.88,7.87A7.91,7.91,0,0,0,71.53,224.26Zm0,13.67a5.8,5.8,0,1,1,5.61-5.8A5.64,5.64,0,0,1,71.53,237.93Z" />
                    <path d="M97.48 236.15L88.52 224.47L86.44 224.47L86.44 239.78L88.63 239.78L88.63 228.09L97.59 239.78L99.67 239.78L99.67 224.47L97.48 224.47L97.48 236.15z" />
                    <path d="M114.59,233.16h5.6a5.67,5.67,0,1,1-5.6-6.83,5.27,5.27,0,0,1,4,1.79l1.56-1.55a7.87,7.87,0,1,0,2.31,5.56v-1h-7.87Z" />
                    <path d="M140,233.16h0l-3.89-8.67h-2.23L127,239.8h2.36l2-4.55h7.15l2,4.55h2.38L140,233.24Zm-7.72,0,2.67-6,2.65,6Z" />
                    <path d="M159.33,233.43a4.43,4.43,0,1,1-8.86,0v-8.94h-2.19v9a6.62,6.62,0,0,0,13.24,0v-9h-2.19Z" />
                    <path d="M171.79 224.49L169.6 224.49L169.6 239.8L181.63 239.8L181.63 237.72L171.79 237.72L171.79 224.49z" />
                    <path d="M187.97 224.47L187.97 239.78L200 239.78L200 237.7L190.16 237.7L190.16 233.12L197.05 233.12L197.05 231.04L190.16 231.04L190.16 226.56L200 226.56L200 224.48L200 224.47L187.97 224.47z" />
                    <path d="M160,99.8a50.47,50.47,0,1,0-60-60,50.47,50.47,0,1,0-60,60,50.46,50.46,0,1,0,60,60,50.46,50.46,0,1,0,60-60ZM98.85,149.12a48.21,48.21,0,1,1-48.2-48.21h48.2Zm0-50.45H50.65a48.21,48.21,0,1,1,48.2-48.21Zm2.26-48.21a48.21,48.21,0,1,1,48.2,48.21h-48.2Zm48.2,146.86a48.26,48.26,0,0,1-48.2-48.2V100.91h48.2a48.21,48.21,0,1,1,0,96.41Z" />
                </svg>
            </i><!-- .main-visual__identity-logo -->
        </div><!-- .main-visual__identity -->
    </div><!-- .main-visual__slider -->

</div><!-- .main-visual -->

<div class="main-section main-connect">
    <div class="wrap">
        <h2 class="main-section__title jt-typo--03">{!! __('front.main.connect.title') !!}</h2>

        <div class="main-section__desc">
            @foreach ( __('front.main.connect.desc') as $desc )
                <p class="jt-typo--10">{!! $desc !!}</p>
            @endforeach
        </div><!-- .main-section__desc -->
    </div><!-- .wrap -->
</div><!-- .main-section -->

<div class="main-section main-garden">
    <div class="main-garden__section">
        <div class="main-garden__bg main-garden__bg--desktop" data-unveil="/assets/front/images/main/main-garden-korea-bg.jpg"></div>
        <div class="main-garden__bg main-garden__bg--mobile" data-unveil="/assets/front/images/main/main-garden-korea-bg-mobile.jpg"></div>

        <div class="main-garden__inner">
            <h3 class="main-garden__title jt-typo--03">{!! __('front.main.garden.korea.title') !!}</h3>
            <p class="main-garden__desc jt-typo--10">{!! __('front.main.garden.korea.desc') !!}</p>

            <div class="main-garden__controls">
                <a href="{{ jt_route('garden.korea') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.main.garden.korea.more') !!}</span></a>
                <a href="https://player.vimeo.com/video/1036205351?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" class="jt-btn__basic jt-btn--type-01 main-garden__preview">
                    <span class="jt-typo--12">{!! __('front.main.garden.korea.preview') !!}</span>
                    <i class="jt-icon">
                        <svg width="17" height="16" viewBox="0 0 17 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.4615 8.00301L4 1.69531V14.3107L13.4615 8.00301Z" />
                        </svg>
                    </i>
                </a>
            </div><!-- .main-garden__controls -->
        </div><!-- .main-garden__inner -->
    </div><!-- .main-garden__section -->
    
    <div class="main-garden__section">
        <div class="main-garden__bg main-garden__bg--desktop" data-unveil="/assets/front/images/main/main-garden-modern-bg.jpg"></div>
        <div class="main-garden__bg main-garden__bg--mobile" data-unveil="/assets/front/images/main/main-garden-modern-bg-mobile.jpg"></div>

        <div class="main-garden__inner">
            <h3 class="main-garden__title jt-typo--03">{!! __('front.main.garden.modern.title') !!}</h3>
            <p class="main-garden__desc jt-typo--10">{!! __('front.main.garden.modern.desc') !!}</p>

            <div class="main-garden__controls">
                <a href="#" class="jt-btn__basic jt-btn--type-01 jt-btn--disabled"><span class="jt-typo--12">Coming soon</span></a>
            </div><!-- .main-garden__controls -->
        </div><!-- .main-garden__inner -->
    </div><!-- .main-garden__section -->
</div><!-- .main-section -->

<div class="main-section main-construct">
    <div class="wrap">

        <div class="main-construct__container">
            <div class="main-construct__content">
                <h2 class="main-section__title jt-typo--03">{!! __('front.main.construct.title') !!}</h2>

                <div class="main-section__desc">
                    <p class="jt-typo--10">{!! __('front.main.construct.desc') !!}</p>
                </div><!-- .main-section__desc -->

                <div class="main-section__more">
                    <a href="{{ jt_route('construct.seongok-seowon') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.more') !!}</span></a>
                </div><!-- .main-section__more -->
            </div><!-- .main-construct__content -->

            <div class="main-construct__image-wrap">
                <div class="main-construct__image-list">
                    <div class="main-construct__image" id="constructor-visitor-center">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="604" height="760" data-unveil="/assets/front/images/main/main-construct-visitor-center.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/main/main-construct-visitor-center.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->

                        <blockquote class="main-construct__source">
                            <cite class="jt-typo--12">{!! __('front.main.construct.visitor-center') !!}</cite>
                        </blockquote><!-- .main-construct__source -->
                    </div><!-- .main-construct__image -->

                    <div class="main-construct__image" id="constructor-pezo-restaurant">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="604" height="760" data-unveil="/assets/front/images/main/main-construct-pezo-restaurant.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/main/main-construct-pezo-restaurant.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->

                        <blockquote class="main-construct__source">
                            <cite class="jt-typo--12">{!! __('front.main.construct.pezo-restaurant') !!}</cite>
                        </blockquote><!-- .main-construct__source -->
                    </div><!-- .main-construct__image -->

                    <div class="main-construct__image main-construct__image--active" id="constructor-seongok">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="604" height="760" data-unveil="/assets/front/images/main/main-construct-seongok.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/main/main-construct-seongok.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->

                        <blockquote class="main-construct__source">
                            <cite class="jt-typo--12">{!! __('front.main.construct.seongok-seowon') !!}</cite>
                        </blockquote><!-- .main-construct__source -->
                    </div><!-- .main-construct__image -->
                </div><!-- .main-construct__image-list -->
            </div><!-- .main-construct__image-wrap -->

            <h2 class="main-section__title main-section__title--mobile jt-typo--03">{!! __('front.main.construct.title') !!}</h2>
        </div><!-- .main-construct__container -->

    </div><!-- .wrap -->
</div><!-- .main-section -->

<div class="main-section main-director">
    <div class="wrap">
        <div class="main-director__sticky">
            <div class="main-director__sticky-inner">
                <h2 class="main-section__title jt-typo--03">{!! __('front.main.director.title') !!}</h2>

                <div class="main-section__desc">
                    <p class="jt-typo--10">{!! __('front.main.director.desc') !!}</p>
                </div><!-- .main-section__desc -->

                <div class="main-section__more">
                    <a href="{{ jt_route('introduce.people') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.more') !!}</span></a>
                </div><!-- .main-section__more -->
            </div><!-- .main-director__sticky-inner -->
        </div><!-- .main-director__sticky -->

        <div class="main-director__container">
            <div class="main-director__item main-director__item--01">
                <div class="main-director__image">
                    <figure class="jt-lazyload">
                        <img width="300" height="240" data-unveil="/assets/front/images/main/main-director-01.jpg?v1.1" src="/assets/front/images/layout/blank.gif" alt="" />
                        <noscript><img src="/assets/front/images/main/main-director-01.jpg?v1.1" alt="" /></noscript>
                    </figure><!-- .jt-lazyload -->
                </div><!-- .main-director__image -->
            </div><!-- .main-director__item -->

            <div class="main-director__item main-director__item--02">
                <div class="main-director__image">
                    <figure class="jt-lazyload">
                        <img width="348" height="460" data-unveil="/assets/front/images/main/main-director-02.jpg?v1.1" src="/assets/front/images/layout/blank.gif" alt="" />
                        <noscript><img src="/assets/front/images/main/main-director-02.jpg?v1.1" alt="" /></noscript>
                    </figure><!-- .jt-lazyload -->
                </div><!-- .main-director__image -->
            </div><!-- .main-director__item -->

            <div class="main-director__item main-director__item--03">
                <div class="main-director__image">
                    <figure class="jt-lazyload">
                        <img width="476" height="476" data-unveil="/assets/front/images/main/main-director-03.jpg?v1.1" src="/assets/front/images/layout/blank.gif" alt="" />
                        <noscript><img src="/assets/front/images/main/main-director-03.jpg?v1.1" alt="" /></noscript>
                    </figure><!-- .jt-lazyload -->
                </div><!-- .main-director__image -->
            </div><!-- .main-director__item -->

            <div class="main-director__item main-director__item--04">
                <div class="main-director__image">
                    <figure class="jt-lazyload">
                        <img width="220" height="220" data-unveil="/assets/front/images/main/main-director-04.jpg?v1.1" src="/assets/front/images/layout/blank.gif" alt="" />
                        <noscript><img src="/assets/front/images/main/main-director-04.jpg?v1.1" alt="" /></noscript>
                    </figure><!-- .jt-lazyload -->
                </div><!-- .main-director__image -->
            </div><!-- .main-director__item -->

            <div class="main-director__item main-director__item--05">
                <div class="main-director__image">
                    <figure class="jt-lazyload">
                        <img width="300" height="240" data-unveil="/assets/front/images/main/main-director-05.jpg?v1.1" src="/assets/front/images/layout/blank.gif" alt="" />
                        <noscript><img src="/assets/front/images/main/main-director-05.jpg?v1.1" alt="" /></noscript>
                    </figure><!-- .jt-lazyload -->
                </div><!-- .main-director__image -->
            </div><!-- .main-director__item -->

            <div class="main-director__item main-director__item--06">
                <div class="main-director__image">
                    <figure class="jt-lazyload">
                        <img width="476" height="476" data-unveil="/assets/front/images/main/main-director-06.jpg?v1.1" src="/assets/front/images/layout/blank.gif" alt="" />
                        <noscript><img src="/assets/front/images/main/main-director-06.jpg?v1.1" alt="" /></noscript>
                    </figure><!-- .jt-lazyload -->
                </div><!-- .main-director__image -->
            </div><!-- .main-director__item -->

            <div class="main-director__more">
                <a href="{{ jt_route('introduce.people') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.more') !!}</span></a>
            </div><!-- .main-director__more -->
        </div><!-- .main-director__container -->
    </div><!-- .wrap -->
</div><!-- .main-section -->

@if( count($sceneries) > 0 )
<div class="main-section main-scenery">
    <div class="wrap">
        <h2 class="main-section__title jt-typo--03">{!! __('front.main.scenery.title') !!}</h2>

        <div class="main-scenery__slider swiper">
            <div class="swiper-wrapper">
                @foreach($sceneries as $scenery)
                    <div class="main-scenery__item swiper-slide">
                        <a href="{{ Storage::url($scenery->thumbnail) }}" target="_blank" class="jt-board__scenery-popup">
                            <div class="main-scenery__image swiper-lazy" data-background="{{ Storage::url($scenery->thumbnail) }}"></div>
                        </a>
                    </div><!-- .main-scenery__item -->
                @endforeach
            </div><!-- .swiper-wrapper -->
        </div><!-- .main-scenery__slider -->

        <div class="main-scenery__pagination swiper">
            <div class="swiper-wrapper">
                <div class="main-scenery__bullet swiper-slide"></div>
                <div class="main-scenery__bullet swiper-slide"></div>
                <div class="main-scenery__bullet swiper-slide"></div>
                <div class="main-scenery__bullet swiper-slide"></div>
                <div class="main-scenery__bullet swiper-slide"></div>
            </div><!-- .swiper-wrapper -->
        </div><!-- .main-scenery__pagination -->
    </div><!-- .wrap -->
</div><!-- .main-section -->
@endif

@if( count($feeds) > 0 )
<div class="main-section main-board">
    <div class="wrap">

        <h2 class="main-section__title jt-typo--03">{!! __('front.main.board.title') !!}</h2>

        <ul class="jt-board__list">
            @foreach($feeds as $feed)
                <li>
                    <a href="{{ $feed->url() }}" target="{{ $feed->use_link ? '_blank' : '_self' }}" rel="{{ $feed->use_link ? 'noopener' : '' }}">
                        <span class="jt-board__list-state jt-typo--09">( {{ $feed->mainLabel }} )</span>
                        <h3 class="jt-board__list-title">
                            <span class="jt-typo--09">{{ $feed->title }}</span>

                            @if($feed->use_link)
                                <i class="jt-icon">
                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                        <path d="M12.71,3.29A1.05,1.05,0,0,0,12,3H5.14a1,1,0,0,0,0,2H9.58L3.29,11.29a1,1,0,0,0,1.42,1.42L11,6.41v4.45a1,1,0,0,0,2,0V4A1.05,1.05,0,0,0,12.71,3.29Z"/>
                                    </svg>
                                </i>
                            @endif
                        </h3><!-- .jt-board__list-title -->
                        <time class="jt-board__list-date jt-typo--12" datetime="{{ $feed->published_at }}">{{ $feed->published_at->format('Y. m. d') }}</time>
                    </a>
                </li>
            @endforeach
        </ul><!-- .jt-board__list -->

        <div class="jt-board__more">
            <a href="{{ jt_route('board.notice.list') }}" class="jt-btn__basic jt-btn--type-01"><span class="jt-typo--12">{!! __('front.ui.more') !!}</span></a>
        </div><!-- .jt-board__more -->
    </div><!-- .wrap -->
</div><!-- .main-section -->
@endif

@push('popup')
    @if( $popups->count() > 0 )
        <div class="jt-popup jt-popup--multiple jt-popup--today main-popup" data-popup-length="{{ $popups->count() }}">

            @foreach($popups as $popup)
            <div class="jt-popup__container" id="main-popup-{{ $popup->id }}" data-top="{{ $popup->top }}" data-left="{{ $popup->left }}">
                <div class="jt-popup__container-inner">
                    <div class="jt-popup__image">
                        @if(!empty($popup->url))
                            <a href="{{ $popup->url }}" target="{{ $popup->target ? '_blank' : '_self' }}" rel="{{ $popup->target ? 'noopener' : '' }}">
                                <img src="{{ Storage::url($popup->image) }}" alt="" />
                            </a>
                        @else
                            <img src="{{ Storage::url($popup->image) }}" alt="" />
                        @endif
                    </div><!-- .jt-popup__image -->

                    <div class="jt-popup__control">
                        <button class="jt-popup__today"><span class="jt-typo--17">{!! __('front.ui.close-today') !!}</span></button>
                        <button class="jt-popup__close"><span class="jt-typo--17">{!! __('front.ui.close') !!}</span></button>
                    </div><!-- .jt-popup__control -->
                </div><!-- .jt-popup__container-inner -->
            </div><!-- .jt-popup__container -->
            @endforeach
        </div><!-- .jt-popup -->

        <div class="jt-popup jt-popup--multiple jt-popup--today main-popup-mobile" id="main-popup-mobile">

            <div class="jt-popup__container">
                <div class="jt-popup__slider swiper">
                    <div class="swiper-wrapper">

                        @foreach($popups as $popup)
                            <div class="jt-popup__slide swiper-slide">
                                @if(!empty($popup->url))
                                    <a href="{{ $popup->url }}" target="{{ $popup->target ? '_blank' : '_self' }}" rel="{{ $popup->target ? 'noopener' : '' }}">
                                        <img src="{{ Storage::url($popup->image) }}" alt="" />
                                    </a>
                                @else
                                    <img src="{{ Storage::url($popup->image) }}" alt="" />
                                @endif
                            </div><!-- .jt-popup__slide -->
                        @endforeach

                    </div><!-- .swiper-wrapper -->

                    <div class="swiper-pagination"></div>
                </div><!-- .jt-popup__slider -->

                <div class="jt-popup__control">
                    <button class="jt-popup__today"><span class="jt-typo--17">{!! __('front.ui.close-today') !!}</span></button>
                    <button class="jt-popup__close"><span class="jt-typo--17">{!! __('front.ui.close') !!}</span></button>
                </div><!-- .jt-popup__control -->
            </div><!-- .jt-popup__container -->

        </div><!-- .jt-popup -->
    @endif

    <div class="main-korea-preview-popup jt-popup">
        <div class="jt-popup__container">
            <div class="jt-popup__container-inner">
                <div class="jt-popup__embed" data-src="https://player.vimeo.com/video/1036205351?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479">
                    <div class="jt-embed-video">
                        <div class="jt-embed-video__inner"></div>

                        <div class="jt-embed-video__poster" data-unveil="/assets/front/images/main/main-connect-video-poster.jpg">
                            <div class="jt-embed-video__play">
                                <i class="jt-icon">
                                    <svg width="72" height="72" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M54.7808 38.674C56.4908 37.534 56.4908 35.0214 54.7808 33.8814L24.6374 13.7858C22.7235 12.5099 20.1599 13.8819 20.1599 16.1821V56.3733C20.1599 58.6735 22.7235 60.0456 24.6374 58.7696L54.7808 38.674Z" />
                                    </svg>
                                </i><!-- .jt-icon -->
                            </div><!-- .jt-background-video__error -->
                        </div><!-- .jt-embed-video__poster -->
                    </div><!-- .jt-embed-video -->
                </div><!-- .jt-popup__embed -->

                <button class="jt-popup__close">
                    <span class="sr-only">{!! __('front.ui.close-popup') !!}</span>
                    <i class="jt-icon">
                        <svg width="52" height="52" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <path d="M47.23,45.8,27.43,26,47.22,6.21a1,1,0,0,0-1.41-1.42L26,24.59,6.22,4.79A1,1,0,0,0,4.81,6.21L24.6,26,4.8,45.8a1,1,0,0,0,1.41,1.42L26,27.41l19.8,19.81a1,1,0,0,0,.71.29,1,1,0,0,0,.7-1.71Z"></path>
                        </svg>
                    </i><!-- .jt-icon -->
                </button><!-- .jt-popup__close -->
            </div><!-- .jt-popup__container-inner -->
        </div><!-- .jt-popup__container -->
    </div><!-- .jt-popup -->

    @if( count($sceneries) > 0 )
        <div class="jt-scenery-popup jt-popup">
            <div class="jt-popup__container">
                <div class="jt-popup__container-inner">
                    <div class="jt-scenery-popup__slider swiper">
                        <div class="swiper-wrapper">
                            @foreach($sceneries as $scenery)
                                <div class="jt-scenery-popup__item swiper-slide">
                                    <div class="jt-scenery-popup__image">
                                        <img src="{{ Storage::url($scenery->thumbnail) }}" alt="" />
                                    </div><!-- .jt-scenery-popup__image -->
                                </div><!-- .jt-scenery-popup__item -->
                            @endforeach
                        </div><!-- .swiper-wrapper -->
                        
                        <div class="swiper-controls">
                            <div class="swiper-button swiper-button-prev">
                                <i class="jt-icon">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M14.4,16.3,8.11,9.92l6.28-6.21A1,1,0,1,0,13,2.29L5.28,9.9,13,17.7a1,1,0,1,0,1.42-1.4Z"/>
                                    </svg>
                                </i><!-- .jt-icon -->
                                <span class="sr-only">{!! __('front.ui.prev') !!}</span>
                            </div><!-- .swiper-button-prev -->

                            <div class="swiper-button swiper-button-next">
                                <i class="jt-icon">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M8.4,17.7l7.71-7.8L8.39,2.29A1,1,0,0,0,7,3.71l6.29,6.21L7,16.3A1,1,0,0,0,8.4,17.7Z"/>
                                    </svg>
                                </i><!-- .jt-icon -->
                                <span class="sr-only">{!! __('front.ui.next') !!}</span>
                            </div><!-- .swiper-button-next -->
                        </div><!-- .swiper-controls -->
                    </div><!-- .main-scenery__slider -->

                    <button class="jt-popup__close">
                        <span class="sr-only">{!! __('front.ui.close-popup') !!}</span>
                        <i class="jt-icon">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M17.55 16.42L11.12 9.99L17.55 3.57L16.42 2.43L9.99 8.86L3.57 2.43L2.43 3.57L8.86 9.99L2.43 16.42L3.56 17.55L9.99 11.12L16.42 17.55L17.55 16.42z" />
                            </svg>
                        </i><!-- .jt-icon -->
                    </button><!-- .jt-popup__close -->
                </div><!-- .jt-popup__container-inner -->
            </div><!-- .jt-popup__container -->
        </div><!-- .jt-popup -->
    @endif
@endpush

@endsection
