@extends('front.partials.layout', [
    'view' => 'manual-visitor-guide',
    'seo_title' => __('front.visitor-guide.title'),
    'seo_description' => __('front.desc.visitor-guide'),
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap">
            <h1 class="article__title jt-typo--02">{!! __('front.visitor-guide.title') !!}</h1>
        </div><!-- .wrap -->
    </div><!-- .article__header -->

    <div class="article__body">

        <div class="manual-visitor-guide-visual">
            <div class="wrap-narrow">
                <div class="manual-visitor-guide-visual__bg manual-visitor-guide-visual__bg--desktop" data-unveil="/assets/front/images/sub/manual-visitor-guide-visual-01.jpg?v1.1"></div>
                <div class="manual-visitor-guide-visual__bg manual-visitor-guide-visual__bg--mobile" data-unveil="/assets/front/images/sub/manual-visitor-guide-visual-01-mobile.jpg?v1.1"></div>
            </div><!-- .wrap-narrow -->
        </div><!-- .manual-visitor-guide-visual -->

        <div class="article__section manual-visitor-guide-anchor jt-anchor">
            <div class="wrap-narrow">
                <div class="manual-visitor-guide-anchor__container">
                    @if($guides->count() > 0)
                        <div class="manual-visitor-guide-anchor__sticky">
                            <div class="manual-visitor-guide-anchor__sticky-inner">
                                <ul class="manual-visitor-guide-anchor__list">
                                    @foreach($guides as $key=>$guide)
                                        <li>
                                            <a href="#section-{{ $guide->id }}"
                                                @class([
                                                    'jt-anchor__btn',
                                                    'jt-anchor--current' => $key == 0
                                                ])
                                            ><span class="jt-typo--12">{{ $guide->title }}</span></a>
                                        </li>
                                    @endforeach
                                </ul><!-- .manual-visitor-guide-anchor__tab -->
                            </div><!-- .manual-visitor-guide-anchor__sticky-inner -->
                        </div><!-- .manual-visitor-guide-anchor__sticky -->

                        <div class="manual-visitor-guide-anchor__content">
                            @foreach($guides as $guide)
                                <div class="manual-visitor-guide-anchor__section jt-anchor__item" id="section-{{ $guide->id }}">
                                    <h2 class="jt-typo--06">{{ $guide->title }}</h2>

                                    @if(!empty($guide->content))
                                        <div class="manual-visitor-guide-anchor__section-inner">
                                            <ul>
                                                @foreach($guide->content as $content)
                                                    <li>
                                                        <h3 class="jt-typo--09">{{ $content['title'] }}</h3>

                                                        @if($content['use_table'])
                                                            <div class="jt-single__content">
                                                                {!! content($content['table']) !!}
                                                            </div><!-- .jt-single__content -->
                                                        @else
                                                            <ul>
                                                                @foreach($content['array'] as $value)
                                                                    <li class="jt-typo--13">{!! nl2br(replace_link(e($value))) !!}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div><!-- .manual-visitor-guide-anchor__section-inner -->
                                    @endif
                                </div><!-- .manual-visitor-guide-anchor__section -->
                            @endforeach
                        </div><!-- .manual-visitor-guide-anchor__content -->
                    @endif
                </div><!-- .manual-visitor-guide-anchor__container -->
            </div><!-- .wrap-narrow -->
        </div><!-- .manual-visitor-guide-anchor -->

    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
