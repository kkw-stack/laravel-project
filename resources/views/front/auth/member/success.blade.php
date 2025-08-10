@extends('front.partials.layout', [
    'view' => 'register-success',
    'seo_title' => __('front.register.success.title'),
    'seo_description' => __('front.desc.register-success'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">{!! __('front.register.success.title') !!}</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">

        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                <h2 class="article__section-title jt-typo--06">{!! __('front.register.success.desc', ['NAME'=>$user->name]) !!}</h2>

                <div class="jt-register-history">
                    @include('front.auth.partials.account-history', compact('user'))

                    <div class="jt-form__control">
                        <a href="{{ jt_route('login') }}" data-barba-prevent class="jt-btn__basic jt-btn--type-01 jt-btn--large"><span class="jt-typo--12">{!! __('front.ui.go-login') !!}</span></a>
                    </div><!-- .jt-form__control -->
                </div><!-- .jt-register-history -->
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection
