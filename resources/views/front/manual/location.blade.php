@extends('front.partials.layout', [
    'view' => 'manual-location',
    'seo_title' => __('front.location.title'),
    'seo_description' => __('front.desc.location'),
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap-narrow">
            <h1 class="article__title jt-typo--02">{!! __('front.location.title') !!}</h1>
        </div><!-- .wrap-narrow -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section menual-location-map">
            <div class="wrap-narrow">
                <div class="menual-location-map__container">
                    <div class="menual-location-map__script jt-map" data-lat="37.4962933" data-lng="127.7283216" data-zoom="16"></div>
                </div><!-- .menual-location-map__container -->

                <div class="menual-location-map__data">
                    <div class="menual-location-map__address">
                        <b class="jt-typo--12">{!! __('front.location.address.title') !!}</b>
                        <p class="jt-typo--13">{!! __('front.location.address.desc') !!}</p>
                    </div><!-- .menual-location-map__address -->

                    @if(app()->getLocale() === 'ko')
                        <div class="menual-location-map__outlink">
                            <a href="https://map.naver.com/p/search/%EA%B2%BD%EA%B8%B0%20%EC%96%91%ED%8F%89%EA%B5%B0%20%EC%96%91%EB%8F%99%EB%A9%B4%20%EB%A9%94%EB%8D%A9%EA%B3%A8%EA%B8%B8%2043/address/14218555.8631779,4508554.7393322,%EA%B2%BD%EA%B8%B0%EB%8F%84%20%EC%96%91%ED%8F%89%EA%B5%B0%20%EC%96%91%EB%8F%99%EB%A9%B4%20%EB%A9%94%EB%8D%A9%EA%B3%A8%EA%B8%B8%2043,new?c=19.00,0,0,0,dh&isCorrectAnswer=true" target="_blank" rel="noopener" class="jt-btn__outlink jt-btn--type-01">
                                <span class="jt-typo--16">네이버맵으로 보기</span>
                                <i class="jt-icon">
                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                        <path d="M12,3.25H4a.75.75,0,0,0,0,1.5h6.19L3.47,11.47a.75.75,0,0,0,1.06,1.06l6.72-6.72V12a.75.75,0,0,0,1.5,0V4A.76.76,0,0,0,12,3.25Z"></path>
                                    </svg>
                                </i><!-- .jt-icon -->
                            </a><!-- .jt-btn__outlink -->
                            <a href="https://map.kakao.com/?urlX=660823&urlY=1110939&urlLevel=3&itemId=582948920&srcid=582948920&map_type=TYPE_MAP" target="_blank" rel="noopener" class="jt-btn__outlink jt-btn--type-01">
                                <span class="jt-typo--16">카카오맵으로 보기</span>
                                <i class="jt-icon">
                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                        <path d="M12,3.25H4a.75.75,0,0,0,0,1.5h6.19L3.47,11.47a.75.75,0,0,0,1.06,1.06l6.72-6.72V12a.75.75,0,0,0,1.5,0V4A.76.76,0,0,0,12,3.25Z"></path>
                                    </svg>
                                </i><!-- .jt-icon -->
                            </a><!-- .jt-btn__outlink -->
                        </div><!-- .menual-location-map__outlink -->
                    @endif
                </div><!-- .menual-location-map__data -->
            </div><!-- .wrap-narrow -->
        </div><!-- .menual-location-map -->

        <div class="article__section menual-location-traffic">
            <div class="wrap-narrow">
                <div class="menual-location-traffic__container">

                    <div class="menual-location-traffic__sticky">
                        <div class="menual-location-traffic__sticky-inner">
                            <h2 class="jt-typo--04">{!! __('front.location.directions.title') !!}</h2>

                            <ul class="menual-location-traffic__tab">
                                <li>
                                    <a href="#tab-01" class="jt-tab__btn jt-tab--active"><span class="jt-typo--12">{!! __('front.location.directions.areas.seoul') !!}</span></a>
                                </li>
                                <li>
                                    <a href="#tab-02" class="jt-tab__btn"><span class="jt-typo--12">{!! __('front.location.directions.areas.daejeon') !!}</span></a>
                                </li>
                                <li>
                                    <a href="#tab-03" class="jt-tab__btn"><span class="jt-typo--12">{!! __('front.location.directions.areas.daegu') !!}</span></a>
                                </li>
                                <li>
                                    <a href="#tab-04" class="jt-tab__btn"><span class="jt-typo--12">{!! __('front.location.directions.areas.busan') !!}</span></a>
                                </li>
                                <li>
                                    <a href="#tab-05" class="jt-tab__btn"><span class="jt-typo--12">{!! __('front.location.directions.areas.gangwon') !!}</span></a>
                                </li>
                            </ul><!-- .menual-location-traffic__tab -->
                        </div><!-- .menual-location-traffic__sticky-inner -->
                    </div><!-- .menual-location-traffic__sticky -->

                    <div class="menual-location-traffic__content">

                        <div class="jt-tab__content jt-tab--active" id="tab-01">
                            <h3 class="sr-only">{!! __('front.location.directions.areas.seoul') !!}</h3>

                            <ul class="menual-location-traffic__list">
                                <li>
                                    <h4 class="menual-location-traffic__subject jt-typo--06">{!! __('front.location.directions.traffic.car') !!}<br class="smbr" />({!! __('front.location.directions.explain', ['MINUTES'=>15]) !!})</h4>

                                    <ul class="menual-location-traffic__data">
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.gyeonggangro') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.olympic') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gyeonggangro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yangdongro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.geumwanggil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.medeonggolgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.dongbuganseon') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.dongbuganseon') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.seongnam-icheonro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gwangju-wonju-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yangdongro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.geumwanggil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.medeonggolgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.seoul-2nd-expressway') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.seoul-2nd-expressway') !!}({!! __('front.location.directions.range.hwado-yangpyeong') !!})</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.jungbu-naeryuk-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gwangju-wonju-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yangdongro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.geumwanggil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.medeonggolgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                    </ul><!-- .menual-location-traffic__data -->
                                </li>
                                <li>
                                    <h4 class="menual-location-traffic__subject jt-typo--06">{!! __('front.location.directions.traffic.bus') !!}</h4>

                                    <ul class="menual-location-traffic__data">
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.east-seoul-terminal') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.east-seoul-terminal') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yongmun-terminal') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.texi', ['MINUTES'=>25]) !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                    </ul><!-- .menual-location-traffic__data -->
                                </li>
                                <li>
                                    <h4 class="menual-location-traffic__subject jt-typo--06">{!! __('front.location.directions.traffic.train') !!}</h4>

                                    <ul class="menual-location-traffic__data">
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.mugunghwa') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.cheongnyangni-station') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yangdong-station') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.texi', ['MINUTES'=>14]) !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.gyeongui-jungang') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.cheongnyangni-station') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yongmun-station') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.texi', ['MINUTES'=>25]) !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                    </ul><!-- .menual-location-traffic__data -->
                                </li>
                            </ul><!-- .menual-location-traffic__list -->
                        </div><!-- .jt-tab__content -->

                        <div class="jt-tab__content" id="tab-02">
                            <h3 class="sr-only">{!! __('front.location.directions.areas.daejeon') !!}</h3>

                            <ul class="menual-location-traffic__list">
                                <li>
                                    <h4 class="menual-location-traffic__subject jt-typo--06">{!! __('front.location.directions.traffic.car') !!}</h4>

                                    <ul class="menual-location-traffic__data">
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.jungbu-expressway') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.jungbu-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.jungbu-naeryuk-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gwangju-wonju-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yangdongro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.geumwanggil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.medeonggolgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                    </ul><!-- .menual-location-traffic__data -->
                                </li>
                            </ul><!-- .menual-location-traffic__list -->
                        </div><!-- .jt-tab__content -->

                        <div class="jt-tab__content" id="tab-03">
                            <h3 class="sr-only">{!! __('front.location.directions.areas.daegu') !!}</h3>

                            <ul class="menual-location-traffic__list">
                                <li>
                                    <h4 class="menual-location-traffic__subject jt-typo--06">{!! __('front.location.directions.traffic.car') !!}</h4>

                                    <ul class="menual-location-traffic__data">
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.jungang-expressway') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.jungang-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gwangju-wonju-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yangdongro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.geumwanggil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.medeonggolgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.jungbu-naeryuk-expressway') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gyeongbu-station') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.jungbu-naeryuk-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gwangju-wonju-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yangdongro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.geumwanggil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.medeonggolgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                    </ul><!-- .menual-location-traffic__data -->
                                </li>
                            </ul><!-- .menual-location-traffic__list -->
                        </div><!-- .jt-tab__content -->

                        <div class="jt-tab__content" id="tab-04">
                            <h3 class="sr-only">{!! __('front.location.directions.areas.busan') !!}</h3>

                            <ul class="menual-location-traffic__list">
                                <li>
                                    <h4 class="menual-location-traffic__subject jt-typo--06">{!! __('front.location.directions.traffic.car') !!}</h4>

                                    <ul class="menual-location-traffic__data">
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.jungang-expressway') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.jungang-expressway') !!}({!! __('front.location.directions.range.busan-daegu') !!})</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.jungang-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gwangju-wonju-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yangdongro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.geumwanggil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.medeonggolgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.jungbu-naeryuk-expressway') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.jungang-expressway') !!}({!! __('front.location.directions.range.busan-daegu') !!})</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gyeongbu-station') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.jungbu-naeryuk-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.yangdongro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.geumwanggil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.medeonggolgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                    </ul><!-- .menual-location-traffic__data -->
                                </li>
                            </ul><!-- .menual-location-traffic__list -->
                        </div><!-- .jt-tab__content -->

                        <div class="jt-tab__content" id="tab-05">
                            <h3 class="sr-only">{!! __('front.location.directions.areas.gangwon') !!}</h3>

                            <ul class="menual-location-traffic__list">
                                <li>
                                    <h4 class="menual-location-traffic__subject jt-typo--06">{!! __('front.location.directions.traffic.car') !!}</h4>

                                    <ul class="menual-location-traffic__data">
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.yangyang-expressway') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.seoul-yangyang-expressway') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.seorakro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gyeonggangro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.morungogaetgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.geumwanggil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.medeonggolgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                        <li>
                                            <b class="menual-location-traffic__data-key jt-typo--09">{!! __('front.location.directions.route.gyeonggangro') !!}</b>
                                            <div class="menual-location-traffic__data-value">
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.guryongnyeongro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.cheongjeongro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.gyeonggangro') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.morungogaetgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.geumwanggil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.road.medeonggolgil') !!}</span>
                                                <span class="jt-typo--13">{!! __('front.location.directions.destination') !!}</span>
                                            </div><!-- .menual-location-traffic__data-value -->
                                        </li>
                                    </ul><!-- .menual-location-traffic__data -->
                                </li>
                            </ul><!-- .menual-location-traffic__list -->
                        </div><!-- .jt-tab__content -->

                    </div><!-- .menual-location-traffic__content -->

                </div><!-- .menual-location-traffic__container -->
            </div><!-- .wrap-narrow -->
        </div><!-- .menual-location-traffic -->

    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
