@php
    $version = "1.2.3";
    $seo_title = trim(!empty($seo_title) ? $seo_title . ' | '.__('front.sitename') : __('front.sitename'));
    $seo_description = mb_substr(trim(preg_replace('/\s+/', ' ', e(strip_tags($seo_description ?? '')))), 0, 160);
    $seo_description = !empty($seo_description) ? $seo_description : __('front.desc.default');
    $seo_image = !empty($seo_image) ? $seo_image : '/assets/front/images/og-image.jpg';

    $is_dev = 'production' !== config('app.env', 'production') || str_contains(config('app.url'), 'studio-jt.co.kr') || str_contains(config('app.url'), 'localhost');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @stack('meta')

    @if($is_dev)
        <meta name="robots" content="noindex, nofollow" />
    @endif

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />

    <title>{{ $seo_title }}</title>

    <meta name="description" content="{{ $seo_description }}" />
    <meta name="keywords" content="" />

    <meta property="og:locale" content="ko_KR">
    <meta property="og:site_name" content="{!! __('front.sitename') !!}" />
    <meta property="og:title" content="{{ $seo_title }}" />
    <meta property="og:description" content="{{ $seo_description }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ url($seo_image) }}" />

    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Favicon -->
    <link rel="icon" href="{{ url('/assets/front/images/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ url('/assets/front/images/favicon-192x192.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ url('/assets/front/images/favicon-180x180.png') }}" />
    <meta name="msapplication-TileImage" content="{{ url('/assets/front/images/favicon-270x270.png') }}" />

    <!-- JS -->
    <script src="/assets/front/js/vendors/browser/browser-selector.js?v=0.5.3"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/front/css/vendors/slider/swiper/swiper-bundle.min.css?v=8.4.2" />
    <link rel="stylesheet" href="/assets/front/css/vendors/select/choices.min.css?v=10.2.0" />
    <link rel="stylesheet" href="/assets/front/css/var.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/font.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/reset.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/jt-strap.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/layout.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/main.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/sub-introduce.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/sub-garden.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/sub-construct.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/sub-board.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/sub-manual.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/sub-user.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/sub-register.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/sub-reservation.css?v={{ $version }}" />

    <!-- RWD -->
    <link rel="stylesheet" href="/assets/front/css/rwd-strap.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/rwd-layout.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/rwd-main.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/rwd-introduce.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/rwd-garden.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/rwd-construct.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/rwd-board.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/rwd-manual.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/rwd-user.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/rwd-register.css?v={{ $version }}" />
    <link rel="stylesheet" href="/assets/front/css/rwd-reservation.css?v={{ $version }}" />

    <!-- EN -->
    @if(app()->getLocale() === 'en')
        <link rel="stylesheet" href="/assets/front/css/lang-en.css?v={{ $version }}" />
    @endif


    @if(!$is_dev)
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-41RS0GYQTG"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-41RS0GYQTG');
        </script>

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-M83929G8');</script>
        <!-- End Google Tag Manager -->
    @endif

    @if ($is_dev)
        @if('reservation-form' === $view)
            @routes
            @viteReactRefresh
            @vite(['resources/js/app.jsx', 'resources/js/pages/' . $page['component'] . '.jsx'])
            @inertiaHead
        @endif
    @endif
</head>

<body class="{{ $view }} {{ Auth::check() ? 'has-auth' : '' }}">

    <div id="skip">
        <a href="#main" class="jt-typo--16">{!! __('front.ui.skip') !!}</a>
    </div><!-- #skip -->

    @includeWhen(!isset($hide_layout), 'front.partials.header')

    <div id="barba-wrapper" data-barba="wrapper">
        <div class="barba-container" data-barba="container">
            <main id="main" class="main-container">

                @yield('content')

            </main><!-- .main_container -->
        </div><!-- .barba-container -->
    </div><!-- #barba-wrapper -->

    @includeWhen(!isset($hide_layout), 'front.partials.footer')

    @stack('popup')

    <div class="jt-popup reservation-comingsoon-popup">
        <div class="jt-popup__container">
            <div class="jt-popup__container-inner">
                <div class="jt-popup__image">
                    <img src="/assets/front/images/layout/reservation-comingsoon{{ 'en' === app()->getLocale() ? '-en' : '' }}.jpg" alt="">
                </div><!-- .jt-popup__image -->

                <button class="jt-popup__close">
                    <span class="sr-only">{!! __('front.ui.close-popup') !!}</span>
                    <i class="jt-icon">
                        <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                            <path d="M25.7,4.29a1,1,0,0,0-1.41,0L15,13.74,5.71,4.3A1,1,0,0,0,4.29,5.7l9.31,9.46-9,9.14A1,1,0,0,0,6,25.7l9-9.11,9,9.11a1,1,0,0,0,1.43-1.4l-9-9.14L25.71,5.7A1,1,0,0,0,25.7,4.29Z"/>
                        </svg>
                    </i><!-- .jt-icon -->
                </button><!-- .jt-popup__close -->
            </div><!-- .jt-popup__container-inner -->
        </div><!-- .jt-popup__container -->
    </div><!-- .jt-popup -->

    <!-- SCRIPT -->
    <script src="/assets/front/js/vendors/greensock/gsap.min.js?v=3.10.3"></script>
    <script src="/assets/front/js/vendors/greensock/ScrollToPlugin.min.js?v=3.10.3"></script>
    <script src="/assets/front/js/vendors/greensock/ScrollTrigger.min.js?v=3.10.3"></script>
    <script src="/assets/front/js/vendors/greensock/MorphSVGPlugin.min.js?v=3.10.3"></script>
    <script src="/assets/front/js/vendors/greensock/DrawSVGPlugin.min.js?v=3.10.3"></script>
    <script src="/assets/front/js/vendors/utilities/imagesloaded.pkgd.min.js?v=5.0.0"></script>
    <script src="/assets/front/js/vendors/slider/swiper/swiper-bundle.min.js?v=8.4.2"></script>
    <script src="/assets/front/js/vendors/select/choices.min.js?v=10.2.0"></script>
    <script src="/assets/front/js/vendors/date/dayjs/dayjs.min.js?v=1.11.12"></script>
    <script src="/assets/front/js/vendors/date/dayjs/locale/ko.js?v=1.11.12"></script>
    <script src="/assets/front/js/vendors/date/dayjs/plugins/objectSupport.js?v=1.11.12"></script>
    <script src="/assets/front/js/vendors/date/dayjs/plugins/customParseFormat.js?v=1.11.12"></script>
    <script src="/assets/front/js/vendors/datepicker/air-datepicker.min.js?v=3.5.3"></script>
    <script src="/assets/front/js/vendors/qrcode/qrcode.min.js?v=1.0.0"></script>
    <script src="/assets/front/js/vendors/sound/howler.min.js?v=2.2.4"></script>
    <script src="/assets/front/js/vendors/barba/barba.min.js?v=2.9.7"></script>
    <script src="/assets/front/js/vendors/jt/jt-autocomplete.min.js?v=1.0.0"></script>
    <script src="/assets/front/js/vendors/jt/jt-unveil.js?v=1.0.0"></script>
    <script src="/assets/front/js/jt.js?v={{ $version }}"></script>
    <script src="/assets/front/js/jt-strap.js?v={{ $version }}"></script>
    <script src="/assets/front/js/main.js?v={{ $version }}"></script>
    <script src="/assets/front/js/form.js?v={{ $version }}"></script>

    @if ('production' !== config('app.env', 'production'))
        <script>
            (function(){
                const triggers = document.querySelectorAll('.header__utils-reserve, .header__address-utils-reserve, .footer__float-btn a, .footer__float-sticky');

                triggers.forEach(( trigger ) => {
                    trigger.addEventListener('click', ( e ) => {

                        if( !trigger.getAttribute('href').startsWith('#') && !document.body.classList.contains('has-auth') ){
                            e.preventDefault();
                            e.stopPropagation();

                            JT.confirm({
                                message     : '{!! __("front.reservation.modal.title") !!}',
                                description : '{!! __("front.reservation.modal.desc") !!}',
                                isChoice    : true,
                                addClass    : 'jt-confirm--choice-auth',
                                confirm     : '{!! __("front.reservation.modal.confirm") !!}',
                                cancel      : '{!! __("front.reservation.modal.cancel") !!}',
                                onConfirm   : () => {
                                    location.href = '{{ jt_route("login", ["redirect_to" => jt_route("reservation.form")]) }}';
                                },
                                onCancel    : () => {
                                    @if( app()->getLocale() !== 'en' )
                                        location.href = '{{ jt_route("reservation.form") }}';
                                    @endif
                                }
                            });
                            return;
                        }
                    });
                });
            })();
        </script>
    @endif

    @stack('script')

    @if(!$is_dev)
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M83929G8" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif
</body>

</html>
