
@isset( $images )

<div class="jt-sub-visual swiper">
    <div class="swiper-wrapper">

        @foreach( $images as $image )
        <div class="jt-sub-visual__item swiper-slide">
            <div class="jt-sub-visual__image jt-sub-visual__image--desktop swiper-lazy" data-background="{{ $image['desktop'] }}" style="background-image: url(/assets/front/images/layout/blank.gif);"></div>
            <div class="jt-sub-visual__image jt-sub-visual__image--mobile swiper-lazy" data-background="{{ $image['mobile'] }}" style="background-image: url(/assets/front/images/layout/blank.gif);"></div>
        </div><!-- .jt-sub-visual__item -->
        @endforeach
        
    </div><!-- .swiper-wrapper -->
</div><!-- .jt-sub-visual -->

@endisset
