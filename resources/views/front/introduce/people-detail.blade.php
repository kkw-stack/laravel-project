
@extends('front.partials.layout', [
    'view' => 'introduce-people',
    'seo_title' => $people->name,
    'seo_description' => $people->content,
    'seo_image' => $people->thumbnail ? Storage::url($people->thumbnail) : '',
])

@section('content')
<div class="article">
    <h1 class="sr-only">{!! __('front.people.title') !!}</h1>

    <div class="article__body">
        <div class="wrap-narrow">
            <div class="article__section introduce-people-popup__data">
                <div class="introduce-people-popup__head">
                    <h2 class="introduce-people-popup__title jt-typo--03">{{ $people->name }}</h2>
                    <p class="introduce-people-popup__desc jt-typo--15">{{ $people->intro }}</p>
                </div><!-- .introduce-people-popup__head -->

                <div class="introduce-people-popup__content">
                    @if( !empty( $people->use_video ) )
                        @if( !empty( $people->video ) )
                        <div class="introduce-people-popup__video jt-popup__embed">
                            <div class="jt-embed-video">
                                <div class="jt-embed-video__inner">
                                    <iframe src="https://player.vimeo.com/video/{{ $people->video }}?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title=""></iframe>
                                </div><!-- .jt-embed-video__inner -->
    
                                <div class="jt-embed-video__poster" data-unveil="{{ Storage::url($people->image) }}">
                                    <div class="jt-embed-video__play">
                                        <i class="jt-icon">
                                            <svg width="72" height="72" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M54.7808 38.674C56.4908 37.534 56.4908 35.0214 54.7808 33.8814L24.6374 13.7858C22.7235 12.5099 20.1599 13.8819 20.1599 16.1821V56.3733C20.1599 58.6735 22.7235 60.0456 24.6374 58.7696L54.7808 38.674Z" />
                                            </svg>
                                        </i><!-- .jt-icon -->
                                    </div><!-- .jt-background-video__error -->
                                </div><!-- .jt-embed-video__poster -->
                            </div><!-- .introduce-people-popup__video -->
                        </div>
                        @else
                        <div class="introduce-people-popup__image">
                            <figure class="jt-lazyload">
                                <span class="jt-lazyload__color-preview"></span>
                                <img width="816" height="458" data-unveil="{{ Storage::url($people->image) }}" src="/assets/front/images/layout/blank.gif" alt="" />
                                <noscript><img src="{{ Storage::url($people->image) }}" alt="" /></noscript>
                            </figure><!-- .jt-lazyload -->
                        </div><!-- .introduce-people-popup__image -->
                        @endif
                    @endif

                    <p class="jt-typo--15">{!! $people->content !!}</p>

                    @php
                        $file = $people->files->first();
                    @endphp
                    @isset($file)
                        <div class="introduce-people-popup__attachment">
                            <a href="{{ Storage::url($file->file_path) }}" download="{{ $file->file_name }}">
                                <span class="jt-typo--16">{!! __('front.people.download') !!}</span>
                            </a>
                        </div><!-- .introduce-people-popup__attachment -->
                    @endisset

                    @if( !empty( $people->masterpiece ) )
                    <div class="introduce-people-popup__piece">
                        <b class="jt-typo--15">( {!! __('front.people.piece') !!} )</b>
                        <span class="jt-typo--15">{{ $people->masterpiece }}</span>
                    </div><!-- .introduce-people-popup__piece -->
                    @endif
                </div><!-- .introduce-people-popup__content -->

                @if( !empty( $people->project ) )
                <div class="introduce-people-popup__project">
                    <h3 class="introduce-people-popup__subtitle jt-typo--06">{!! __('front.people.project') !!}</h3>

                    <ul class="introduce-people-popup__project-list">
                        @foreach( $people->project as $project )
                        <li class="introduce-people-popup__project-item">
                            <div class="introduce-people-popup__project-thumb">
                                <figure class="jt-lazyload">
                                    <span class="jt-lazyload__color-preview"></span>
                                    <img width="392" height="240" data-unveil="{{ !empty( $project['image'] ) ? Storage::url($project['image']) : '/assets/front/images/sub/introduce-people-detail-project-no-image.jpg' }}" src="/assets/front/images/layout/blank.gif" alt="" />
                                    <noscript><img src="{{ !empty( $project['image'] ) ? Storage::url($project['image']) : '/assets/front/images/sub/introduce-people-detail-project-no-image.jpg' }}" alt="" /></noscript>
                                </figure><!-- .jt-lazyload -->
                            </div><!-- .introduce-people-gallery__thumb-->
                            <b class="introduce-people-popup__project-title jt-typo--16">{{ $project['explanation'] }}</b>
                        </li><!-- .introduce-people-popup__project-item -->
                        @endforeach
                    </ul><!-- .introduce-people-popup__project-list -->
                </div><!-- .introduce-people-popup__project -->
                @endif
            </div><!-- .introduce-people-popup__data -->
        </div><!-- .wrap -->
    </div><!-- .article__body -->
</div><!-- .article -->

@endsection
