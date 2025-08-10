@isset( $peoples )

<ul class="introduce-people-gallery__list">
    @foreach( $peoples as $people )
        <li class="introduce-people-gallery__item">
            <a href="{{ jt_route('introduce.people.detail', compact('people')) }}">
                <div class="introduce-people-gallery__thumb">
                    <figure class="jt-lazyload">
                        <span class="jt-lazyload__color-preview"></span>
                        <img width="348" height="400" data-unveil="{{ Storage::url($people->thumbnail) }}" src="/assets/front/images/layout/blank.gif" alt="" />
                        <noscript><img src="{{ Storage::url($people->thumbnail) }}" alt="" /></noscript>
                    </figure><!-- .jt-lazyload -->
                </div><!-- .introduce-people-gallery__thumb-->

                <div class="introduce-people-gallery__data">
                    <h2 class="introduce-people-gallery__name"><span class="jt-typo--06">{!! $people->name !!}</span></h2>
                    <p class="introduce-people-gallery__desc"><span class="jt-typo--15">{!! $people->intro !!}</span></p>
                </div><!-- .introduce-people-gallery__data -->
            </a>
        </li><!-- .introduce-people-gallery__item -->
    @endforeach

</ul><!-- .introduce-people-gallery__list -->

@endisset
