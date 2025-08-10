
@isset( $list )

<div class="construct-visual">

    @foreach( $list as $key => $item )
    <div class="construct-visual__section construct-visual__section--{{ Str::of( $key + 1 )->padLeft(2, '0') }}">

        @if( $item['type'] === 'image' )
        <div class="construct-visual__bg construct-visual__bg--desktop" data-unveil="{{ $item['image']['desktop'] }}"></div>
        <div class="construct-visual__bg construct-visual__bg--mobile" data-unveil="{{ $item['image']['mobile'] }}"></div>
        @elseif( $item['type'] === 'video' )
        <div class="construct-visual__video construct-visual__video--desktop">
            <div class="jt-background-video jt-autoplay-inview">
                <div class="jt-background-video__vod">
                    <video playsinline loop muted>
                        <source src="{{ $item['video']['desktop'] }}" type="video/mp4" />
                    </video>
                </div><!-- .jt-background-video__vod -->
                <div class="jt-background-video__poster" data-unveil="{{ $item['poster']['desktop'] }}"></div>
            </div><!-- .jt-background-video -->
        </div><!-- .construct-visual__video -->
        <div class="construct-visual__video construct-visual__video--mobile">
            <div class="jt-background-video jt-autoplay-inview">
                <div class="jt-background-video__vod">
                    <video playsinline loop muted>
                        <source src="{{ $item['video']['mobile'] }}" type="video/mp4" />
                    </video>
                </div><!-- .jt-background-video__vod -->
                <div class="jt-background-video__poster" data-unveil="{{ $item['poster']['mobile'] }}"></div>
            </div><!-- .jt-background-video -->
        </div><!-- .construct-visual__video -->
        @endif

        <div class="construct-visual__content">
            <div class="wrap">
                @if( !empty( $item['title'] ) )
                <h1 class="construct-visual__title jt-typo--01">{!! $item['title'] !!}</h1>
                <p class="construct-visual__desc jt-typo--10">{!! $item['desc'] !!}</p>
                @else
                <p class="construct-visual__desc jt-typo--04">{!! $item['desc'] !!}</p>
                @endif
            </div><!-- .wrap -->
        </div><!-- .construct-visual__content -->
    </div><!-- .construct-visual__section -->
    @endforeach

</div><!-- .construct-visual -->

@endisset