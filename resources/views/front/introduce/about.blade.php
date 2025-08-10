@extends('front.partials.layout', [
    'view' => 'introduce-about',
    'seo_title' => __('front.about.title'),
    'seo_description' => __('front.desc.about'),
])

@section('content')

<div class="article">
    <h1 class="sr-only">{!! __('front.about.title') !!}</h1>

    <div class="introduce-about__visual">

        <div class="introduce-about__visual-sticky">
            <div class="introduce-about__visual-bg introduce-about__visual--desktop" data-unveil="/assets/front/images/sub/introduce-about-visual.jpg"></div>
            <div class="introduce-about__visual-bg introduce-about__visual--mobile" data-unveil="/assets/front/images/sub/introduce-about-visual-mobile.jpg"></div>

            <div class="introduce-about__visual-inner">

                <div class="introduce-about__visual-section introduce-about__visual-section--01">
                    <p class="jt-typo--06">{!! __('front.about.visual.desc')[0] !!}</p>
                </div><!-- .introduce-about__visual-section -->

                <div class="introduce-about__visual-section introduce-about__visual-section--02">
                    <p class="jt-typo--06">{!! __('front.about.visual.desc')[1] !!}</p>
                </div><!-- .introduce-about__visual-section -->

                <div class="introduce-about__visual-section introduce-about__visual-section--03">
                    <p class="jt-typo--06">{!! __('front.about.visual.desc')[2] !!}</p>
                </div><!-- .introduce-about__visual-section -->

                <div class="introduce-about__visual-section introduce-about__visual-epilogue">
                    <div class="introduce-about__visual-epilogue-bg introduce-about__visual-epilogue--desktop" data-unveil="/assets/front/images/sub/introduce-about-visual-epilogue.jpg"></div>
                    <div class="introduce-about__visual-epilogue-bg introduce-about__visual-epilogue--mobile" data-unveil="/assets/front/images/sub/introduce-about-visual-epilogue.jpg"></div>
                    <div class="introduce-about__visual-epilogue-backdrop"></div>

                    <div class="introduce-about__visual-title">
                        <b class="jt-typo--02">{!! __('front.about.visual.title') !!}</b>
                    </div><!-- .introduce-about__visual-title -->
                </div><!-- .introduce-about__visual-epilogue -->

                <div class="introduce-about__visual-scrolldown">
                    <i class="jt-icon">
                        <svg width="36" height="36" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36">
                            <path d="M33.18,10.26a1,1,0,0,0-1.42.06L18.67,24.53,5.23,10.31a1,1,0,0,0-1.46,1.38L18,26.69a1,1,0,0,0,1.46,0l13.83-15A1,1,0,0,0,33.18,10.26Z"/>
                        </svg>
                    </i><!-- .jt-icon -->
                </div><!-- .introduce-about__visual-scrolldown -->
            </div><!-- .introduce-about__visual-inner -->
        </div><!-- .introduce-about__visual-sticky -->
    </div><!-- .introduce-about__visual -->

    <div class="article__body">

        <div class="article__section article__section--primary introduce-about__keypoint">
            <div class="introduce-about__keypoint-group">
                <div class="introduce-about__keypoint-visual introduce-about__keypoint-visual--video">
                    <div class="jt-background-video jt-autoplay-inview">
                        <div class="jt-background-video__vod">
                            <video playsinline loop muted>
                                <source src="https://player.vimeo.com/progressive_redirect/playback/970431976/rendition/1080p/file.mp4?loc=external&signature=10c8e5376268f640c347f8782c50a3b389270ffcd65b9257ca0d3d40f055dc41" type="video/mp4" />
                            </video>
                        </div><!-- .jt-background-video__vod -->
                        <div class="jt-background-video__poster" data-unveil="/assets/front/images/sub/introduce-about-keypoint-mission-poster.jpg">
                            <div class="jt-background-video__error">
                                <i class="jt-icon">
                                    <svg width="72" height="72" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M54.7808 38.674C56.4908 37.534 56.4908 35.0214 54.7808 33.8814L24.6374 13.7858C22.7235 12.5099 20.1599 13.8819 20.1599 16.1821V56.3733C20.1599 58.6735 22.7235 60.0456 24.6374 58.7696L54.7808 38.674Z" />
                                    </svg>
                                </i><!-- .jt-icon -->
                            </div><!-- .jt-background-video__error -->
                        </div><!-- .jt-background-video__poster -->
                    </div><!-- .jt-background-video -->
                </div><!-- .introduce-about__keypoint-visual -->

                <div class="introduce-about__keypoint-content">
                    <h2 class="introduce-about__keypoint-title jt-typo--03">{!! __('front.about.keypoint.mission.title') !!}</h2>
                    <p class="introduce-about__keypoint-desc jt-typo--10">{!! __('front.about.keypoint.mission.desc') !!}</p>
                </div><!-- .introduce-about__keypoint-content -->
            </div><!-- .introduce-about__keypoint-group -->

            <div class="introduce-about__keypoint-group">
                <div class="introduce-about__keypoint-visual introduce-about__keypoint-visual--image" data-unveil="/assets/front/images/sub/introduce-about-keypoint-vision.jpg"></div>

                <div class="introduce-about__keypoint-content">
                    <h2 class="introduce-about__keypoint-title jt-typo--03">{!! __('front.about.keypoint.vision.title') !!}</h2>
                    <p class="introduce-about__keypoint-desc jt-typo--10">{!! __('front.about.keypoint.vision.desc') !!}</p>
                </div><!-- .introduce-about__keypoint-content -->
            </div><!-- .introduce-about__keypoint-group -->

            <div class="introduce-about__keypoint-group">
                <div class="introduce-about__keypoint-visual introduce-about__keypoint-visual--image" data-unveil="/assets/front/images/sub/introduce-about-keypoint-core.jpg"></div>

                <div class="introduce-about__keypoint-content">
                    <h2 class="introduce-about__keypoint-title jt-typo--03">{!! __('front.about.keypoint.core.title') !!}</h2>
                    <p class="introduce-about__keypoint-desc jt-typo--10">{!! __('front.about.keypoint.core.desc') !!}</p>
                </div><!-- .introduce-about__keypoint-content -->
            </div><!-- .introduce-about__keypoint-group -->
        </div><!-- .introduce-about__keypoint -->

        <div class="article__section introduce-about__identity">
            <h2 class="sr-only">{!! __('front.about.identity.title') !!}</h2>

            <div class="introduce-about__identity-bg introduce-about__identity--desktop" data-unveil="/assets/front/images/sub/introduce-about-identity.jpg">
                <div class="introduce-about__identity-backdrop"></div>
            </div><!-- .introduce-about__identity-bg -->

            <div class="introduce-about__identity-bg introduce-about__identity--mobile" data-unveil="/assets/front/images/sub/introduce-about-identity-mobile.jpg">
                <div class="introduce-about__identity-backdrop"></div>
            </div><!-- .introduce-about__identity-bg -->

            <div class="introduce-about__identity-inner">
                <div class="wrap">
                    <div class="introduce-about__identity-logo">
                        <div class="introduce-about__identity-symbol">
                            <svg width="360" height="360" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360 360">
                                <path d="M288.2,180A91,91,0,1,0,180,71.8,91,91,0,1,0,71.8,180,91,91,0,1,0,180,288.2,91,91,0,1,0,288.2,180ZM269,4.07A86.95,86.95,0,1,1,269,178H182V91A87,87,0,0,1,269,4.07ZM4.1,91A86.93,86.93,0,1,1,178,91V178H91A87,87,0,0,1,4.1,91ZM91,355.9A86.95,86.95,0,1,1,91,182H178V269A87,87,0,0,1,91,355.9Zm178,0A87,87,0,0,1,182,269V182H269a86.95,86.95,0,1,1,0,173.89Z"/>
                            </svg>                            
                        </div><!-- .introduce-about__identity-symbol -->

                        <div class="introduce-about__identity-typo">
                            <svg width="360" height="40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360 40">
                                <path d="M13.78,22.13,3.54,10.88H0V38.43H3.94V17.05h0l9.84,10.67,9.84-10.67V38.42h3.94V10.88H24Z"/>
                                <path d="M42.48,38.42H64.13V34.69H46.42V26.42h12.4V22.68H46.42V14.61H64.13V10.88H42.48Z"/>
                                <path d="M59,1H54.44L51.05,8.12h3.39Z"/>
                                <path d="M90.28,10.89H78.51V38.44H90.28a13.78,13.78,0,1,0,0-27.55Zm0,23.8H82.46V14.61h7.82c5.51,0,9.68,4.33,9.68,10s-4.15,10-9.67,10Z"/>
                                <path d="M128.74,10.49a14.17,14.17,0,1,0,14.17,14.16h0A14.24,14.24,0,0,0,128.74,10.49Zm0,24.6a10.13,10.13,0,0,1-10.08-10.4,10.08,10.08,0,1,1,20.16,0,10.11,10.11,0,0,1-10.07,10.4Z"/>
                                <path d="M175.46,31.89l-16.14-21h-3.74V38.42h3.94v-21l16.14,21h3.74V10.88h-3.94Z"/>
                                <path d="M206.23,26.5H216.3a10.14,10.14,0,0,1-20.15-1.81,10.12,10.12,0,0,1,10.08-10.4,9.41,9.41,0,0,1,7.2,3.2l2.79-2.8a14.12,14.12,0,1,0,4.18,10V22.77H206.23Z"/>
                                <path d="M251.92,26.5h0l-7-15.62h-4L228.58,38.42h4.22l3.62-8.18h12.86l3.62,8.18h4.29l-5.27-11.81Zm-13.85,0,4.8-10.78,4.8,10.78Z"/>
                                <path d="M286.78,27a8,8,0,1,1-15.93,1.43,8.54,8.54,0,0,1,0-1.43V10.88h-4V27.05a11.92,11.92,0,0,0,23.83,0V10.88h-4Z"/>
                                <path d="M309.22,10.88h-4V38.42h21.65V34.69h-17.7Z"/>
                                <path d="M360,14.61V10.88H338.35V38.42H360V34.69H342.29V26.42h12.4V22.68h-12.4V14.61Z"/>
                            </svg>
                        </div><!-- .introduce-about__identity-typo -->
                    </div><!-- .introduce-about__identity-logo -->

                    <p class="introduce-about__identity-desc jt-typo--10">{!! __('front.about.identity.desc') !!}</p>
                </div><!-- .wrap -->
            </div><!-- .introduce-about__identity-inner -->
        </div><!-- .introduce-about__identity -->

        <div class="article__section introduce-about__gallery">
            <div class="wrap">

                <div class="introduce-about__gallery-item introduce-about__gallery-item--01">
                    <div class="introduce-about__gallery-image">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="604" height="664" data-unveil="/assets/front/images/sub/introduce-about-gallery-01.jpg?v1.1" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/introduce-about-gallery-01.jpg?v1.1" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .introduce-about__gallery-image -->

                    <p class="introduce-about__gallery-title jt-typo--09">{!! __('front.about.gallery')[0] !!}</p>
                </div><!-- .introduce-about__gallery-item -->

                <div class="introduce-about__gallery-item introduce-about__gallery-item--02">
                    <div class="introduce-about__gallery-image">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="604" height="664" data-unveil="/assets/front/images/sub/introduce-about-gallery-02.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/introduce-about-gallery-02.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .introduce-about__gallery-image -->

                    <p class="introduce-about__gallery-title jt-typo--09">{!! __('front.about.gallery')[1] !!}</p>
                </div><!-- .introduce-about__gallery-item -->

                <div class="introduce-about__gallery-item introduce-about__gallery-item--03">
                    <div class="introduce-about__gallery-image">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="604" height="664" data-unveil="/assets/front/images/sub/introduce-about-gallery-03.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/introduce-about-gallery-03.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .introduce-about__gallery-image -->

                    <p class="introduce-about__gallery-title jt-typo--09">{!! __('front.about.gallery')[2] !!}</p>
                </div><!-- .introduce-about__gallery-item -->

                <div class="introduce-about__gallery-item introduce-about__gallery-item--04">
                    <div class="introduce-about__gallery-image">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="604" height="664" data-unveil="/assets/front/images/sub/introduce-about-gallery-04.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/introduce-about-gallery-04.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .introduce-about__gallery-image -->

                    <p class="introduce-about__gallery-title jt-typo--09">{!! __('front.about.gallery')[3] !!}</p>
                </div><!-- .introduce-about__gallery-item -->

            </div><!-- .wrap -->
        </div><!-- .introduce-about__gallery -->

    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
