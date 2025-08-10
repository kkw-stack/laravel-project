<div class="jt-take">
    <b class="jt-typo--06">{!! isset( $title ) ? $title : __('front.empty.title') !!}</b>
    <p class="jt-typo--13">{!! isset( $desc ) ? $desc : __('front.empty.desc') !!}</p>

    @if( !empty( $link ) )
    <div class="jt-take__controls">
        <a href="{{ $link['href'] ?? jt_route('index') }}" class="jt-btn__basic jt-btn--type-01 jt-btn--large" target="{{ $link['target'] ?? '_self' }}" {!! !empty($link['target']) && $link['target'] === '_blank' ? 'rel="noopener"' : '' !!} {{ ( !empty($link['nobarba']) && $link['nobarba'] ) ? 'data-barba-prevent' : '' }}>
            <span class="jt-typo--12">{!! $link['text'] ?? __('front.ui.go-home') !!}</span>
        </a><!-- .jt-btn__basic -->
    </div><!-- .jt-take__controls -->
    @endif
</div><!-- .jt-take -->
