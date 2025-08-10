@extends('front.partials.layout', [
    'view' => 'construct-seongok-seowon',
    'seo_title' => __('front.seongok-seowon.title'),
    'seo_description' => __('front.desc.seongok-seowon'),
])

@section('content')

<div class="article">

    @include('front.construct.partials.construct-visual', ['list'=>[
        ['type' => 'image', 'title' => __('front.seongok-seowon.visual.title'), 'desc' => __('front.seongok-seowon.visual.desc'), 'image' => [ 'desktop' => '/assets/front/images/sub/construct-seongok-seowon-visual-01.jpg', 'mobile' => '/assets/front/images/sub/construct-seongok-seowon-visual-01-mobile.jpg' ]]
    ]])

    <div class="article__body">

        <div class="article__section construct-seongok-seowon__intro">
            <div class="wrap">
                <h2 class="article__section-title jt-typo--03">{!! __('front.seongok-seowon.intro.title') !!}</h2>

                <div class="article__section-desc">
                    <p class="jt-typo--13">{!! __('front.seongok-seowon.intro.desc') !!}</p>
                </div><!-- .main-section__desc -->
            </div><!-- .wrap -->

            <div class="construct-seongok-seowon__intro-bg" data-unveil="/assets/front/images/sub/construct-seongok-seowon-intro.jpg"></div>
        </div><!-- .construct-seongok-seowon__intro -->

        <div class="article__section construct-seongok-seowon__gallery">
            <div class="wrap">


                <div class="construct-seongok-seowon__gallery-grid">
                    <div class="construct-seongok-seowon__gallery-group">
                        <h2 class="construct-seongok-seowon__gallery-title jt-typo--03">{!! __('front.seongok-seowon.gallery.title') !!}</h2>

                        <div class="construct-seongok-seowon__gallery-item construct-seongok-seowon__gallery-item--01">
                            <div class="construct-seongok-seowon__gallery-image">
                                <figure class="jt-lazyload">
                                    <span class="jt-lazyload__color-preview"></span>
                                    <img width="640" height="760" data-unveil="/assets/front/images/sub/construct-seongok-seowon-gallery-01.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                                    <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-gallery-01.jpg" alt="" /></noscript>
                                </figure><!-- .jt-lazyload -->
                            </div><!-- .construct-seongok-seowon__gallery-image -->

                            <div class="construct-seongok-seowon__gallery-data">
                                <b class="construct-seongok-seowon__gallery-name jt-typo--09">{!! __('front.seongok-seowon.gallery.list')[0]['title'] !!}</b>
                                <p class="construct-seongok-seowon__gallery-desc jt-typo--15">{!! __('front.seongok-seowon.gallery.list')[0]['desc'] !!}</p>
                            </div><!-- .construct-seongok-seowon__gallery-data -->
                        </div><!-- .construct-seongok-seowon__gallery-item -->

                        <div class="construct-seongok-seowon__gallery-item construct-seongok-seowon__gallery-item--02">
                            <div class="construct-seongok-seowon__gallery-image">
                                <figure class="jt-lazyload">
                                    <span class="jt-lazyload__color-preview"></span>
                                    <img width="640" height="640" data-unveil="/assets/front/images/sub/construct-seongok-seowon-gallery-02.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                                    <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-gallery-02.jpg" alt="" /></noscript>
                                </figure><!-- .jt-lazyload -->
                            </div><!-- .construct-seongok-seowon__gallery-image -->

                            <div class="construct-seongok-seowon__gallery-data">
                                <b class="construct-seongok-seowon__gallery-name jt-typo--09">{!! __('front.seongok-seowon.gallery.list')[1]['title'] !!}</b>
                                <p class="construct-seongok-seowon__gallery-desc jt-typo--15">{!! __('front.seongok-seowon.gallery.list')[1]['desc'] !!}</p>
                            </div><!-- .construct-seongok-seowon__gallery-data -->
                        </div><!-- .construct-seongok-seowon__gallery-item -->

                        <div class="construct-seongok-seowon__gallery-item construct-seongok-seowon__gallery-item--03">
                            <div class="construct-seongok-seowon__gallery-image">
                                <figure class="jt-lazyload">
                                    <span class="jt-lazyload__color-preview"></span>
                                    <img width="640" height="760" data-unveil="/assets/front/images/sub/construct-seongok-seowon-gallery-03.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                                    <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-gallery-03.jpg" alt="" /></noscript>
                                </figure><!-- .jt-lazyload -->
                            </div><!-- .construct-seongok-seowon__gallery-image -->

                            <div class="construct-seongok-seowon__gallery-data">
                                <b class="construct-seongok-seowon__gallery-name jt-typo--09">{!! __('front.seongok-seowon.gallery.list')[2]['title'] !!}</b>
                                <p class="construct-seongok-seowon__gallery-desc jt-typo--15">{!! __('front.seongok-seowon.gallery.list')[2]['desc'] !!}</p>
                            </div><!-- .construct-seongok-seowon__gallery-data -->
                        </div><!-- .construct-seongok-seowon__gallery-item -->
                    </div><!-- .construct-seongok-seowon__gallery-group -->

                    <div class="construct-seongok-seowon__gallery-group">
                        <div class="construct-seongok-seowon__gallery-item construct-seongok-seowon__gallery-item--04">
                            <div class="construct-seongok-seowon__gallery-image">
                                <figure class="jt-lazyload">
                                    <span class="jt-lazyload__color-preview"></span>
                                    <img width="640" height="640" data-unveil="/assets/front/images/sub/construct-seongok-seowon-gallery-04.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                                    <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-gallery-04.jpg" alt="" /></noscript>
                                </figure><!-- .jt-lazyload -->
                            </div><!-- .construct-seongok-seowon__gallery-image -->

                            <div class="construct-seongok-seowon__gallery-data">
                                <b class="construct-seongok-seowon__gallery-name jt-typo--09">{!! __('front.seongok-seowon.gallery.list')[3]['title'] !!}</b>
                                <p class="construct-seongok-seowon__gallery-desc jt-typo--15">{!! __('front.seongok-seowon.gallery.list')[3]['desc'] !!}</p>
                            </div><!-- .construct-seongok-seowon__gallery-data -->
                        </div><!-- .construct-seongok-seowon__gallery-item -->

                        <div class="construct-seongok-seowon__gallery-item construct-seongok-seowon__gallery-item--05">
                            <div class="construct-seongok-seowon__gallery-image">
                                <figure class="jt-lazyload">
                                    <span class="jt-lazyload__color-preview"></span>
                                    <img width="640" height="460" data-unveil="/assets/front/images/sub/construct-seongok-seowon-gallery-05.jpg?v1.1" src="/assets/front/images/layout/blank.gif" alt="" />
                                    <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-gallery-05.jpg?v1.1" alt="" /></noscript>
                                </figure><!-- .jt-lazyload -->
                            </div><!-- .construct-seongok-seowon__gallery-image -->

                            <div class="construct-seongok-seowon__gallery-data">
                                <b class="construct-seongok-seowon__gallery-name jt-typo--09">{!! __('front.seongok-seowon.gallery.list')[4]['title'] !!}</b>
                                <p class="construct-seongok-seowon__gallery-desc jt-typo--15">{!! __('front.seongok-seowon.gallery.list')[4]['desc'] !!}</p>
                            </div><!-- .construct-seongok-seowon__gallery-data -->
                        </div><!-- .construct-seongok-seowon__gallery-item -->

                        <div class="construct-seongok-seowon__gallery-item construct-seongok-seowon__gallery-item--06">
                            <div class="construct-seongok-seowon__gallery-image">
                                <figure class="jt-lazyload">
                                    <span class="jt-lazyload__color-preview"></span>
                                    <img width="640" height="760" data-unveil="/assets/front/images/sub/construct-seongok-seowon-gallery-06.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                                    <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-gallery-06.jpg" alt="" /></noscript>
                                </figure><!-- .jt-lazyload -->
                            </div><!-- .construct-seongok-seowon__gallery-image -->

                            <div class="construct-seongok-seowon__gallery-data">
                                <b class="construct-seongok-seowon__gallery-name jt-typo--09">{!! __('front.seongok-seowon.gallery.list')[5]['title'] !!}</b>
                                <p class="construct-seongok-seowon__gallery-desc jt-typo--15">{!! __('front.seongok-seowon.gallery.list')[5]['desc'] !!}</p>
                            </div><!-- .construct-seongok-seowon__gallery-data -->
                        </div><!-- .construct-seongok-seowon__gallery-item -->

                        <div class="construct-seongok-seowon__gallery-item construct-seongok-seowon__gallery-item--07">
                            <div class="construct-seongok-seowon__gallery-image">
                                <figure class="jt-lazyload">
                                    <span class="jt-lazyload__color-preview"></span>
                                    <img width="640" height="640" data-unveil="/assets/front/images/sub/construct-seongok-seowon-gallery-07.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                                    <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-gallery-07.jpg" alt="" /></noscript>
                                </figure><!-- .jt-lazyload -->
                            </div><!-- .construct-seongok-seowon__gallery-image -->

                            <div class="construct-seongok-seowon__gallery-data">
                                <b class="construct-seongok-seowon__gallery-name jt-typo--09">{!! __('front.seongok-seowon.gallery.list')[6]['title'] !!}</b>
                                <p class="construct-seongok-seowon__gallery-desc jt-typo--15">{!! __('front.seongok-seowon.gallery.list')[6]['desc'] !!}</p>
                            </div><!-- .construct-seongok-seowon__gallery-data -->
                        </div><!-- .construct-seongok-seowon__gallery-item -->
                    </div><!-- .construct-seongok-seowon__gallery-group -->
                </div><!-- .construct-seongok-seowon__gallery-grid -->

            </div><!-- .wrap -->
        </div><!-- .construct-seongok-seowon__gallery -->

        {{-- <div class="article__section construct-seongok-seowon__director">
            <div class="wrap">
                <h2 class="article__section-title jt-typo--03">{!! __('front.seongok-seowon.director.title') !!}</h2>

                <div class="article__section-desc">
                    <p class="jt-typo--13">{!! __('front.seongok-seowon.director.desc') !!}</p>
                </div><!-- .main-section__desc -->

                <blockquote class="construct-seongok-seowon__director-source">
                    <cite class="jt-typo--17">{!! __('front.seongok-seowon.director.source') !!}</cite>
                </blockquote><!-- .construct-seongok-seowon__director-source -->
            </div><!-- .wrap -->

            <div class="construct-seongok-seowon__director-gallery">
                <div class="construct-seongok-seowon__director-marquee">
                    <div class="construct-seongok-seowon__director-image construct-seongok-seowon__director-image--01">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="392" height="600" data-unveil="/assets/front/images/sub/construct-seongok-seowon-director-01.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-director-01.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .construct-seongok-seowon__director-image -->

                    <div class="construct-seongok-seowon__director-image construct-seongok-seowon__director-image--02">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="790" height="600" data-unveil="/assets/front/images/sub/construct-seongok-seowon-director-02.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-director-02.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .construct-seongok-seowon__director-image -->

                    <div class="construct-seongok-seowon__director-image construct-seongok-seowon__director-image--03">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="600" height="600" data-unveil="/assets/front/images/sub/construct-seongok-seowon-director-03.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-director-03.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .construct-seongok-seowon__director-image -->

                    <div class="construct-seongok-seowon__director-image construct-seongok-seowon__director-image--04">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="476" height="600" data-unveil="/assets/front/images/sub/construct-seongok-seowon-director-04.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-director-04.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .construct-seongok-seowon__director-image -->

                    <div class="construct-seongok-seowon__director-image construct-seongok-seowon__director-image--05">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="476" height="600" data-unveil="/assets/front/images/sub/construct-seongok-seowon-director-05.jpg?v1.1" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-director-05.jpg?v1.1" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .construct-seongok-seowon__director-image -->

                    <div class="construct-seongok-seowon__director-image construct-seongok-seowon__director-image--06">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="476" height="600" data-unveil="/assets/front/images/sub/construct-seongok-seowon-director-06.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-director-06.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .construct-seongok-seowon__director-image -->

                    <div class="construct-seongok-seowon__director-image construct-seongok-seowon__director-image--07">
                        <figure class="jt-lazyload">
                            <span class="jt-lazyload__color-preview"></span>
                            <img width="790" height="600" data-unveil="/assets/front/images/sub/construct-seongok-seowon-director-07.jpg" src="/assets/front/images/layout/blank.gif" alt="" />
                            <noscript><img src="/assets/front/images/sub/construct-seongok-seowon-director-07.jpg" alt="" /></noscript>
                        </figure><!-- .jt-lazyload -->
                    </div><!-- .construct-seongok-seowon__director-image -->
                </div><!-- .construct-seongok-seowon__director-marquee -->
            </div><!-- .construct-seongok-seowon__director-marquee -->
        </div><!-- .construct-seongok-seowon__director --> --}}

    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
