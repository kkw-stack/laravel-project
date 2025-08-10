@php
    $logoTag = ( $view === 'home' ? 'h1' : 'div' );
    $isDev = config('app.env', 'production') === 'development';
@endphp
<header id="header">
    <div class="header__inner">
        <{{ $logoTag }} id="logo">
            <a href="{{ jt_route('index') }}">
                <span class="sr-only">{!! __('front.header.logo') !!}</span>
                <svg width="222" height="26" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 222 26">
                    <path d="M10.32 14.75L4.14 7.95L2 7.95L2 24.59L4.38 24.59L4.38 11.69L10.32 18.13L16.27 11.69L16.27 24.6L18.65 24.6L18.65 7.95L16.51 7.95L10.32 14.75z" />
                    <path d="M37.63 2L34.9 2L32.85 6.28L34.9 6.28L37.63 2z" />
                    <path d="M27.66 24.61L40.74 24.61L40.74 22.34L30.03 22.34L30.03 17.35L37.52 17.35L37.52 15.08L30.03 15.08L30.03 10.21L40.74 10.21L40.74 7.95L27.66 7.95L27.66 24.61z" />
                    <path d="M56.54,8h-7.1V24.6h7.1A8.33,8.33,0,1,0,56.54,8Zm0,14.38H51.82V10.21h4.72a5.84,5.84,0,0,1,5.86,6.06A5.85,5.85,0,0,1,56.54,22.33Z" />
                    <path d="M79.79,7.71a8.57,8.57,0,1,0,8.57,8.56A8.6,8.6,0,0,0,79.79,7.71Zm0,14.86a6.12,6.12,0,0,1-6.09-6.3,6.09,6.09,0,1,1,12.18,0A6.12,6.12,0,0,1,79.78,22.57Z" />
                    <path d="M108.01 20.64L98.25 7.95L95.99 7.95L95.99 24.6L98.37 24.6L98.37 11.9L108.12 24.6L110.39 24.6L110.39 7.95L108.01 7.95L108.01 20.64z" />
                    <path d="M126.6,17.38h6.09a6.13,6.13,0,0,1-12.18-1.11A6.11,6.11,0,0,1,126.6,10,5.72,5.72,0,0,1,131,11.92l1.69-1.69a8.55,8.55,0,1,0,2.52,6V15.13H126.6Z" />
                    <path d="M154.2,17.38h0L150,8h-2.44l-7.44,16.65h2.57l2.19-4.95h7.78l2.18,4.95h2.59l-3.18-7.14Zm-8.36,0,2.89-6.51,2.88,6.51Z" />
                    <path d="M175.26,17.67a4.82,4.82,0,1,1-9.63,0V8h-2.38v9.77a7.2,7.2,0,0,0,14.39,0V8h-2.38Z" />
                    <path d="M188.81 7.95L186.43 7.95L186.43 24.6L199.52 24.6L199.52 22.33L188.81 22.33L188.81 7.95z" />
                    <path d="M219.49 10.21L219.49 7.95L206.41 7.95L206.41 24.61L219.49 24.61L219.49 22.34L208.79 22.34L208.79 17.35L216.28 17.35L216.28 15.08L208.79 15.08L208.79 10.21L219.49 10.21z" />
                </svg>
            </a>
        </{{ $logoTag }}><!-- #logo -->

        <div class="header__container">
            <div class="header__menu">
                <a href="#" id="menu-controller" class="menu-controller">
                    <div class="menu-controller__box">
                        <span class="menu-controller__line menu-controller__line--01"></span>
                        <span class="menu-controller__line menu-controller__line--02"></span>
                    </div><!-- .menu-controller__box -->
                    <div class="menu-controller__text">
                        <div class="menu-controller__text-track">
                            <b class="jt-typo--16">{!! __('front.ui.menu') !!}</b>
                            <b class="jt-typo--16">{!! __('front.ui.close') !!}</b>
                        </div><!-- .menu-controller__text-track -->
                    </div><!-- .menu-controller__text -->
                </a><!-- #menu-controller -->
            </div><!-- .header__menu -->

            <div class="header__utils">
                <a href="#" class="header__utils-sound" data-sound="/assets/front/sound/sound.mp3">
                    <span class="header__utils-sound-equalizer">
                        <i class="jt-icon">
                            <svg width="120" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 20">
                                <path d="M0,8c5,0,5,4,10,4s5-4,10-4s5,4,10,4s5-4,10-4s5,4,10,4s5-4,10-4s5,4,10,4s5-4,10-4s5,4,10,4c5,0,5-4,10-4s5,4,10,4c5,0,5-4,10-4" />
                            </svg>
                        </i><!-- .jt-icon -->
                        <span class="jt-typo--16">Sound</span>
                    </span><!-- .header__utils-sound-equalizer -->
                </a><!-- .header__utils-sound -->

                @if( $isDev )
                    @if(Auth::check())
                        <a href="{{ jt_route('member.reservation.list') }}" class="header__utils-auth" data-barba-prevent><span class="jt-typo--16">{!! __('front.header.mypage') !!}</span></a>
                    @else
                        <a href="{{ jt_route('login') }}" class="header__utils-auth" data-barba-prevent><span class="jt-typo--16">{!! __('front.header.login') !!}</span></a>
                    @endif
                @endif
                    
                @if('en' === App::getLocale())
                    <a href="{{ route('ko.index') }}" class="header__utils-language" data-barba-prevent><span class="jt-typo--16">KO</span></a>
                @else
                    <a href="{{ route('en.index') }}" class="header__utils-language" data-barba-prevent><span class="jt-typo--16">EN</span></a>
                @endif

                @if( $isDev )
                    <a href="{{ $isDev && jt_route_has('reservation.form') ? jt_route('reservation.form') : '#' }}" class="header__utils-reserve jt-btn__basic jt-btn--type-01 jt-btn--small" data-barba-prevent><span class="jt-typo--16">{!! __('front.header.reservation') !!}</span></a>
                @endif
            </div><!-- .header__utils -->
        </div><!-- .header__container -->
    </div><!-- .header__inner -->

    <nav id="menu-container" class="menu-container">
        <div class="menu-container__overlay"></div>
        <div class="menu-container__inner">
            <ul id="menu">
                <li
                    @class([
                        'menu-item',
                        'menu-item-has-children',
                        'current-menu-ancestor' => jt_route_is('introduce.*')
                    ])
                >
                    <a href="{{ jt_route('introduce.about') }}">
                        <span class="jt-typo--06">{!! __('front.menu.introduce') !!}</span>
                        <i class="jt-icon"><svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M5.3,10.71l8.1,8a1,1,0,0,0,.71.29,1,1,0,0,0,.7-.3l7.9-8a1,1,0,0,0-1.42-1.4l-7.2,7.29L6.7,9.29a1,1,0,0,0-1.4,1.42Z"/></svg></i>
                    </a>
                    <ul class="sub-menu">
                        <li
                            @class([
                                'menu-item',
                                'current-menu-item' => jt_route_is('introduce.about')
                            ])
                        >
                            <a href="{{ jt_route('introduce.about') }}"><span class="jt-typo--12">{!! __('front.menu.about') !!}</span></a>
                        </li><!-- .menu-item -->

                        <li
                            @class([
                                'menu-item',
                                'current-menu-item' => jt_route_is('introduce.history')
                            ])
                        >
                            <a href="{{ jt_route('introduce.history') }}"><span class="jt-typo--12">{!! __('front.menu.history') !!}</span></a>
                        </li><!-- .menu-item -->

                        <li
                            @class([
                                'menu-item',
                                'current-menu-item' => jt_route_is('introduce.people') || jt_route_is('introduce.people.*')
                            ])
                        >
                            <a href="{{ jt_route('introduce.people') }}"><span class="jt-typo--12">{!! __('front.menu.people') !!}</span></a>
                        </li><!-- .menu-item -->

                        <li
                            @class([
                                'menu-item',
                                'current-menu-item' => jt_route_is('introduce.sustainability')
                            ])
                        >
                            <a href="{{ jt_route('introduce.sustainability') }}"><span class="jt-typo--12">{!! __('front.menu.sustainability') !!}</span></a>
                        </li><!-- .menu-item -->
                    </ul><!-- .sub-menu -->
                </li><!-- .menu-item -->

                <li
                    @class([
                        'menu-item',
                        'menu-item-has-children',
                        'current-menu-ancestor' => jt_route_is('garden.*')
                    ])
                >
                    <a href="{{ jt_route('garden.korea') }}">
                        <span class="jt-typo--06">{!! __('front.menu.garden') !!}</span>
                        <i class="jt-icon"><svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M5.3,10.71l8.1,8a1,1,0,0,0,.71.29,1,1,0,0,0,.7-.3l7.9-8a1,1,0,0,0-1.42-1.4l-7.2,7.29L6.7,9.29a1,1,0,0,0-1.4,1.42Z"/></svg></i>
                    </a>
                    <ul class="sub-menu">
                        <li
                            @class([
                                'menu-item',
                                'current-menu-item' => jt_route_is('garden.korea')
                            ])
                        >
                            <a href="{{ jt_route('garden.korea') }}"><span class="jt-typo--12">{!! __('front.menu.korea') !!}</span></a>
                        </li><!-- .menu-item -->
                        
                        @if( $isDev )
                            <li
                                @class([
                                    'menu-item',
                                    'current-menu-item' => jt_route_is('garden.modern')
                                ])
                            >
                                <a href="#"><span class="jt-typo--12">{!! __('front.menu.modern') !!}</span></a>
                            </li><!-- .menu-item -->
                        @endif
                    </ul><!-- .sub-menu -->
                </li><!-- .menu-item -->

                <li
                    @class([
                        'menu-item',
                        'menu-item-has-children',
                        'current-menu-ancestor' => jt_route_is('construct.*')
                    ])
                >
                    <a href="{{ jt_route('construct.seongok-seowon') }}">
                        <span class="jt-typo--06">{!! __('front.menu.construct') !!}</span>
                        <i class="jt-icon"><svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M5.3,10.71l8.1,8a1,1,0,0,0,.71.29,1,1,0,0,0,.7-.3l7.9-8a1,1,0,0,0-1.42-1.4l-7.2,7.29L6.7,9.29a1,1,0,0,0-1.4,1.42Z"/></svg></i>
                    </a>
                    <ul class="sub-menu">
                        <li
                            @class([
                                'menu-item',
                                'current-menu-item' => jt_route_is('construct.seongok-seowon')
                            ])
                        >
                            <a href="{{ jt_route('construct.seongok-seowon') }}"><span class="jt-typo--12">{!! __('front.menu.seongok-seowon') !!}</span></a>
                        </li><!-- .menu-item -->

                        <li
                            @class([
                                'menu-item',
                                'current-menu-item' => jt_route_is('construct.visitor-center')
                            ])
                        >
                            <a href="{{ jt_route('construct.visitor-center') }}"><span class="jt-typo--12">{!! __('front.menu.visitor-center') !!}</span></a>
                        </li><!-- .menu-item -->

                        <li
                            @class([
                                'menu-item',
                                'current-menu-item' => jt_route_is('construct.pezo-restaurant')
                            ])
                        >
                            <a href="{{ jt_route('construct.pezo-restaurant') }}"><span class="jt-typo--12">{!! __('front.menu.pezo-restaurant') !!}</span></a>
                        </li><!-- .menu-item -->
                    </ul><!-- .sub-menu -->
                </li><!-- .menu-item -->

                <li
                    @class([
                        'menu-item',
                        'menu-item-has-children',
                        'current-menu-ancestor' => jt_route_is('board.*')
                    ])
                >
                    <a href="{{ jt_route('board.notice.list') }}">
                        <span class="jt-typo--06">{!! __('front.menu.board') !!}</span>
                        <i class="jt-icon"><svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M5.3,10.71l8.1,8a1,1,0,0,0,.71.29,1,1,0,0,0,.7-.3l7.9-8a1,1,0,0,0-1.42-1.4l-7.2,7.29L6.7,9.29a1,1,0,0,0-1.4,1.42Z"/></svg></i>
                    </a>
                    <ul class="sub-menu">
                        <li
                            @class([
                                'menu-item',
                                'current-menu-item' => jt_route_is('board.notice.*')
                            ])
                        >
                            <a href="{{ jt_route('board.notice.list') }}">
                                <span class="jt-typo--12">{!! __('front.menu.notice') !!}</span>
                            </a>
                        </li><!-- .menu-item -->

                        <li
                            @class([
                                'menu-item',
                                'current-menu-item' => jt_route_is('board.news.*')
                            ])
                        >
                            <a href="{{ jt_route('board.news.list') }}">
                                <span class="jt-typo--12">{!! __('front.menu.news') !!}</span>
                            </a>
                        </li><!-- .menu-item -->
                        
                        @if( $isDev )
                            <li
                                @class([
                                    'menu-item',
                                    'current-menu-item' => jt_route_is('board.event.*')
                                ])
                            >
                                <a href="{{ jt_route('board.event.list') }}">
                                    <span class="jt-typo--12">{!! __('front.menu.event') !!}</span>
                                </a>
                            </li><!-- .menu-item -->

                            <li
                                @class([
                                    'menu-item',
                                    'current-menu-item' => jt_route_is('board.scenery.*')
                                ])
                            >
                                <a href="{{ jt_route('board.scenery.list') }}">
                                    <span class="jt-typo--12">{!! __('front.menu.scenery') !!}</span>
                                </a>
                            </li><!-- .menu-item -->
                        @endif
                    </ul><!-- .sub-menu -->
                </li><!-- .menu-item -->

                @if( $isDev )
                    <li
                        @class([
                            'menu-item',
                            'menu-item-has-children',
                            'current-menu-ancestor' => jt_route_is('manual.*')
                        ])
                    >
                        <a href="{{ jt_route('manual.visitor-guide') }}">
                            <span class="jt-typo--06">{!! __('front.menu.manual') !!}</span>
                            <i class="jt-icon"><svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M5.3,10.71l8.1,8a1,1,0,0,0,.71.29,1,1,0,0,0,.7-.3l7.9-8a1,1,0,0,0-1.42-1.4l-7.2,7.29L6.7,9.29a1,1,0,0,0-1.4,1.42Z"/></svg></i>
                        </a>
                        <ul class="sub-menu">
                            <li
                                @class([
                                    'menu-item',
                                    'current-menu-item' => jt_route_is('manual.visitor-guide')
                                ])
                            >
                                <a href="{{ jt_route('manual.visitor-guide') }}">
                                    <span class="jt-typo--12">{!! __('front.menu.visitor-guide') !!}</span>
                                </a>
                            </li><!-- .menu-item -->

                            <li
                                @class([
                                    'menu-item',
                                    'current-menu-item' => jt_route_is('manual.food-and-beverage')
                                ])
                            >
                                <a href="{{ jt_route('manual.food-and-beverage') }}">
                                    <span class="jt-typo--12">{!! __('front.menu.food-and-beverage') !!}</span>
                                </a>
                            </li><!-- .menu-item -->

                            @if( $isDev )
                                <li
                                    @class([
                                        'menu-item',
                                        'current-menu-item' => jt_route_is('manual.venue-rentals')
                                    ])
                                >
                                    <a href="{{ jt_route('manual.venue-rentals') }}">
                                        <span class="jt-typo--12">{!! __('front.menu.venue-rentals') !!}</span>
                                    </a>
                                </li><!-- .menu-item -->

                                <li
                                    @class([
                                        'menu-item',
                                        'current-menu-item' => jt_route_is('manual.wedding')
                                    ])
                                >
                                    <a href="{{ jt_route('manual.wedding') }}">
                                        <span class="jt-typo--12">{!! __('front.menu.wedding') !!}</span>
                                    </a>
                                </li><!-- .menu-item -->
                            @endif

                            <li
                                @class([
                                    'menu-item',
                                    'current-menu-item' => jt_route_is('manual.faq')
                                ])
                            >
                                <a href="{{ jt_route('manual.faq') }}">
                                    <span class="jt-typo--12">{!! __('front.menu.faq') !!}</span>
                                </a>
                            </li><!-- .menu-item -->

                            <li
                                @class([
                                    'menu-item',
                                    'current-menu-item' => jt_route_is('manual.location')
                                ])
                            >
                                <a href="{{ jt_route('manual.location') }}">
                                    <span class="jt-typo--12">{!! __('front.menu.location') !!}</span>
                                </a>
                            </li><!-- .menu-item -->

                            <li
                                @class([
                                    'menu-item',
                                    'current-menu-item' => jt_route_is('manual.local-attractions')
                                ])
                            >
                                <a href="{{ jt_route('manual.local-attractions') }}"><span class="jt-typo--12">{!! __('front.menu.local-attractions') !!}</span></a>
                            </li><!-- .menu-item -->
                        </ul><!-- .sub-menu -->
                    </li><!-- .menu-item -->
                @endif
            </ul><!-- #menu -->

            <div class="header__address">
                <div class="header__inner">
                    <div class="header__address-inner">
                        <div class="header__address-utils">
                                <div class="header__address-utils-group header__address-utils-group--01">
                                    @if( $isDev )
                                        @if(Auth::check())
                                            <a href="{{ jt_route('member.reservation.list') }}" data-barba-prevent><span class="jt-typo--12">{!! __('front.header.mypage') !!}</span></a>
                                        @else
                                            <a href="{{ jt_route('login') }}" data-barba-prevent><span class="jt-typo--12">{!! __('front.header.login') !!}</span></a>
                                        @endif

                                        @if( jt_route_has('reservation.form') )
                                            <a href="{{ jt_route('reservation.form') }}" class="header__address-utils-reserve" data-barba-prevent><span class="jt-typo--12">{!! __('front.header.reservation') !!}</span></a>
                                        @endif
                                    @endif
                                    
                                    @if('en' === App::getLocale())
                                        <a href="{{ route('ko.index') }}" data-barba-prevent><span class="jt-typo--12">KO</span></a>
                                    @else
                                        <a href="{{ route('en.index') }}" data-barba-prevent><span class="jt-typo--12">EN</span></a>
                                    @endif
                                </div><!-- .header__address-utils-group -->

                            <div class="header__address-utils-group header__address-utils-group--02">
                                <a href="https://www.instagram.com/medongaule/" target="_blank" rel="noopener">
                                    <i class="jt-icon">
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M12,8.83A3.17,3.17,0,1,0,15.17,12,3.22,3.22,0,0,0,12,8.83Z"/>
                                            <path d="M16.06,2.5H8A5.44,5.44,0,0,0,2.5,7.94v8A5.46,5.46,0,0,0,8,21.5h8A5.44,5.44,0,0,0,21.5,16v-8A5.42,5.42,0,0,0,16.06,2.5ZM12,17a4.92,4.92,0,0,1-4.92-4.92,5,5,0,0,1,4.92-5A4.92,4.92,0,0,1,16.92,12,5,5,0,0,1,12,17Zm5.1-8.9A1.12,1.12,0,1,1,18.22,7,1.14,1.14,0,0,1,17.1,8.11Z"/>
                                        </svg>
                                    </i><!-- .jt-icon -->
                                    <span class="sr-only">{!! __('front.ui.instagram') !!}</span>
                                </a>
                                {{-- <a href="https://tagdetail.com/viewer/66e1357f198642ca8889a436" target="_blank" rel="noopener">
                                    <i class="jt-icon">
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M14.46,5.79,9.54,3.08V18.15l4.92,2.71Z"/>
                                            <path d="M8.12,2.91,2.5,4.66V19.72L8.12,18Z"/>
                                            <path d="M15.88,6V21.09l5.62-1.36V4.66Z"/>
                                        </svg>
                                    </i><!-- .jt-icon -->
                                    <span class="sr-only">{!! __('front.ui.leaflet') !!}</span>
                                </a> --}}
                            </div><!-- .header__address-utils-group -->
                        </div><!-- .header__address-utils -->

                        @if( $isDev )
                            <p class="jt-typo--17">{!! __('front.header.address') !!}<span> / </span>OPEN. 10:00AM - 06:00PM</p>
                        @else
                            <p class="jt-typo--17">{!! __('front.header.address') !!}</p>
                        @endif
                    </div><!-- .header__address-inner -->
                </div><!-- .header__inner -->
            </div><!-- .header__address -->
        </div><!-- .menu-container__inner -->
    </nav><!-- .menu-container -->

</header><!-- #header -->
