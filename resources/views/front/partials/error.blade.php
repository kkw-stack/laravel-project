<div class="error-404">
    <div class="error-404__background-top">
        <div class="error-404__background-video error-404__background--desktop">
            <div class="jt-background-video jt-autoplay-inview">
                <div class="jt-background-video__vod">
                    <video playsinline loop muted>
                        <source src="/assets/front/video/sub/bird.mp4" type="video/mp4" />
                    </video>
                </div><!-- .jt-background-video__vod -->
            </div><!-- .jt-background-video -->
        </div><!-- .error-404__background-video -->

        <div class="error-404__background-video error-404__background--mobile">
            <div class="jt-background-video jt-autoplay-inview">
                <div class="jt-background-video__vod">
                    <video playsinline loop muted>
                        <source src="/assets/front/video/sub/bird-mobile.mp4" type="video/mp4" />
                    </video>
                </div><!-- .jt-background-video__vod -->
            </div><!-- .jt-background-video -->
        </div><!-- .error-404__background-video -->
    </div><!-- .error-404__background-top -->

    <div class="error-404__background-bottom">
        <div class="error-404__background-video">
            <div class="jt-background-video jt-autoplay-inview">
                <div class="jt-background-video__vod">
                    <video playsinline loop muted>
                        <source src="/assets/front/video/sub/fog.mp4" type="video/mp4" />
                    </video>
                </div><!-- .jt-background-video__vod -->
                <div class="jt-background-video__poster" data-unveil="/assets/front/images/sub/error-404-background-bottom-poster.jpg"></div>
            </div><!-- .jt-background-video -->
        </div><!-- .error-404__background-video -->
    </div><!-- .error-404__background-bottom -->

	<div class="error-404__inner">
		<div class="wrap">
			<h1 class="jt-typo--01">{!! $title !!}</h1>
			<p class="jt-typo--13">{!! $message !!}</p>

			<div class="error-404__control">
				<a class="jt-btn__basic jt-btn--type-01" href="{{ jt_route('index') }}"><span class="jt-typo--12">{!! __('front.ui.go-home') !!}</span></a>
			</div><!-- .error-404__control -->
		</div><!-- .wrap -->
	</div><!-- .error-404__inner -->
</div><!-- .error-404 -->
