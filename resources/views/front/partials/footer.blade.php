@php
    $isDev = config('app.env', 'production') === 'development';
@endphp
<footer id="footer">
    <div class="footer__inner">
        <div class="footer__float">
            <div class="footer__float-container">
                <b class="footer__float-title">
                    <svg width="450" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 450 50">
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
                </b><!-- .footer__float-title -->

                <div class="footer__float-btn">
                    @if( $isDev )
                        <a href="{{ $isDev && jt_route_has('reservation.form') ? jt_route('reservation.form') : '#' }}" class="jt-btn__basic jt-btn--type-01 jt-btn--small" data-barba-prevent><span class="jt-typo--16">{!! __('front.footer.reservation') !!}</span></a>
                    @endif

                    <div class="footer__float-images">
                        <div class="footer__float-image footer__float-image--default">
                            <figure class="jt-lazyload">
                                <img width="440" height="440" data-unveil="/assets/front/images/layout/footer-float-01.png" src="/assets/front/images/layout/blank.gif" alt="" />
                                <noscript><img src="/assets/front/images/layout/footer-float-01.png" alt="" /></noscript>
                            </figure><!-- .jt-lazyload -->
                        </div><!-- .footer__float-image -->

                        <div class="footer__float-image footer__float-image--hover">
                            <figure class="jt-lazyload">
                                <img width="440" height="440" data-unveil="/assets/front/images/layout/footer-float-02.png" src="/assets/front/images/layout/blank.gif" alt="" />
                                <noscript><img src="/assets/front/images/layout/footer-float-02.png" alt="" /></noscript>
                            </figure><!-- .jt-lazyload -->
                        </div><!-- .footer__float-image -->
                    </div><!-- .footer__float-images -->
                </div><!-- .footer__float-btn -->
            </div><!-- .footer__float-container -->
        </div><!-- .footer__top -->

        <div class="footer__content">
            <div class="footer__content-top">
                <nav class="footer__menu-container">
                    <ul class="footer__menu-list">
                        <li><a href="{{ jt_route('introduce.about') }}"><span class="jt-typo--12">{!! __('front.menu.introduce') !!}</span></a></li>
                        <li><a href="{{ jt_route('garden.korea') }}"><span class="jt-typo--12">{!! __('front.menu.garden') !!}</span></a></li>
                        <li><a href="{{ jt_route('construct.seongok-seowon') }}"><span class="jt-typo--12">{!! __('front.menu.construct') !!}</span></a></li>
                        @if( $isDev && jt_route_has('reservation.form'))
                            <li><a href="{{ jt_route('reservation.form') }}" data-barba-prevent><span class="jt-typo--12">{!! __('front.menu.reservation') !!}</span></a></li>
                        @endif
                        <li><a href="{{ jt_route('board.notice.list') }}"><span class="jt-typo--12">{!! __('front.menu.board') !!}</span></a></li>
                        @if( $isDev )
                            <li><a href="{{ jt_route('manual.visitor-guide') }}"><span class="jt-typo--12">{!! __('front.menu.manual') !!}</span></a></li>
                        @endif
                    </ul><!-- .footer__menu-list -->
                </nav><!-- .footer__menu-container -->

                <div class="footer__outlink">
                    <a href="https://www.instagram.com/medongaule/" target="_blank" rel="noopener" class="jt-btn__outlink jt-btn--type-02">
                        <span class="jt-typo--16">{!! __('front.ui.instagram') !!}</span>
                        <i class="jt-icon">
                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                <path d="M12,3.25H4a.75.75,0,0,0,0,1.5h6.19L3.47,11.47a.75.75,0,0,0,1.06,1.06l6.72-6.72V12a.75.75,0,0,0,1.5,0V4A.76.76,0,0,0,12,3.25Z" />
                            </svg>
                        </i><!-- .jt-icon -->
                    </a><!-- .jt-btn__outlink -->
                    {{-- <a href="https://tagdetail.com/viewer/66e1357f198642ca8889a436" target="_blank" rel="noopener" class="jt-btn__outlink jt-btn--type-02">
                        <span class="jt-typo--16">{!! __('front.ui.leaflet') !!}</span>
                        <i class="jt-icon">
                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                <path d="M12,3.25H4a.75.75,0,0,0,0,1.5h6.19L3.47,11.47a.75.75,0,0,0,1.06,1.06l6.72-6.72V12a.75.75,0,0,0,1.5,0V4A.76.76,0,0,0,12,3.25Z" />
                            </svg>
                        </i><!-- .jt-icon -->
                    </a><!-- .jt-btn__outlink --> --}}
                </div><!-- .footer__utils -->
            </div><!-- .footer__content-top -->

            <div class="footer__content-bottom">
                <div class="footer__info">
                    @if( $isDev )
                        <ul class="footer__register">
                            <li class="jt-typo--17">{!! __('front.footer.company.label') !!} : {!! __('front.footer.company.value') !!}</li>
                            <li class="jt-typo--17">{!! __('front.footer.representative.label') !!} : {!! __('front.footer.representative.value') !!}</li>
                            <li class="jt-typo--17">{!! __('front.footer.address.label') !!} : {!! __('front.footer.address.value') !!}</li>
                            <li class="jt-typo--17">{!! __('front.footer.business-number.label') !!} : 687-88-02161</li>
                            <li class="jt-typo--17">{!! __('front.footer.mailorder-number.label') !!} : 제2025-경기양평-0709호</li>
                            <li class="jt-typo--17">{!! __('front.footer.contact.label') !!} : <a href="tel:031-771-1700">031-771-1700</a></li>
                        </ul><!-- .footer__register -->
                    @endif

                    <div class="footer__policy">
                        <a href="https://www.instagram.com/medongaule/" target="_blank" rel="noopener" class="jt-btn__outlink jt-btn--type-02">
                            <span class="jt-typo--17">{!! __('front.ui.instagram') !!}</span>
                            <i class="jt-icon">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                    <path d="M12,3.25H4a.75.75,0,0,0,0,1.5h6.19L3.47,11.47a.75.75,0,0,0,1.06,1.06l6.72-6.72V12a.75.75,0,0,0,1.5,0V4A.76.76,0,0,0,12,3.25Z" />
                                </svg>
                            </i><!-- .jt-icon -->
                        </a><!-- .jt-btn__outlink -->
                        {{-- <a href="https://tagdetail.com/viewer/66e1357f198642ca8889a436" target="_blank" rel="noopener" class="jt-btn__outlink jt-btn--type-02">
                            <span class="jt-typo--17">{!! __('front.ui.leaflet') !!}</span>
                            <i class="jt-icon">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                    <path d="M12,3.25H4a.75.75,0,0,0,0,1.5h6.19L3.47,11.47a.75.75,0,0,0,1.06,1.06l6.72-6.72V12a.75.75,0,0,0,1.5,0V4A.76.76,0,0,0,12,3.25Z" />
                                </svg>
                            </i><!-- .jt-icon -->
                        </a><!-- .jt-btn__outlink --> --}}
                        @if( $isDev )
                            <a href="{{ jt_route('policy.terms') }}"><span class="jt-typo--17">{!! __('front.footer.terms') !!}</span></a>
                            <a href="{{ jt_route('policy.privacy') }}" class="footer__privacy"><span class="jt-typo--17">{!! __('front.footer.privacy') !!}</span></a>
                        @endif
                    </div><!-- .footer__policy -->
                </div><!-- .footer__info -->

                <div class="footer__copyright">
                    <p class="jt-typo--17">&copy; 2024 Médongaule. All Rights Reserved.</p>
                    <p class="jt-typo--17">Weather and air quality data from KMA and Korea Environment Corporation.</p>
                </div><!-- .footer__copyright -->
            </div><!-- .footer__content-top -->
        </div><!-- .footer__bottom -->
    </div><!-- .footer__inner -->

    @if( $isDev )
        <a href="{{ $isDev && jt_route_has('reservation.form') ? jt_route('reservation.form') : '#' }}" class="footer__float-sticky" data-barba-prevent>
            <div class="footer__float-sticky-inner">
                <i class="jt-icon">
                    <svg width="22" height="21" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 21">
                        <path d="M18,2V1a1,1,0,0,0-2,0V2H6V1A1,1,0,0,0,4,1V2H0V21H22V2Zm2,17H2V4H4V5A1,1,0,0,0,6,5V4H16V5a1,1,0,0,0,2,0V4h2Z"/>
                        <path d="M15.28,8.31l-5,5.24L7.72,10.92A1,1,0,1,0,6.28,12.3l4,4.15,6.47-6.76a1,1,0,0,0-1.44-1.38Z"/>
                    </svg>
                </i><!-- .jt-icon -->
                <span class="jt-typo--17">{!! __('front.ui.float') !!}</span>
            </div><!-- .footer__float-sticky-inner -->
        </a><!-- .footer__float-sticky -->
    @endif
</footer><!-- #footer -->
