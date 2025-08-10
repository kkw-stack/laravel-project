@extends('front.partials.layout', [
    'view' => 'reservation-form',
    'seo_title' => __('front.reservation.form.title'),
    'seo_description' => __('front.desc.reservation-form'),
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-narrow">
            <h1 class="article__title jt-typo--02">{!! __('front.reservation.form.title') !!}</h1>
        </div><!-- .wrap-narrow -->
    </div><!-- .article__header -->

    <div class="jt-strap">
        <div class="wrap-narrow">
            <div class="jt-strap__inner">
                <div class="jt-strap__content">
                    <h2 class="jt-strap__title jt-typo--09">{!! __('front.reservation.form.notification.title') !!}</h2>
                    <ul class="jt-strap__desc">
                        @foreach ( __('front.reservation.form.notification.desc') as $desc )
                            <li class="jt-typo--15">{!! $desc !!}</li>
                        @endforeach
                    </ul><!-- .jt-strap__list -->
                </div><!-- .jt-strap__content -->
            </div><!-- .jt-strap__inner -->
        </div><!-- .wrap-narrow -->
    </div><!-- .jt-strap -->

    <div class="article__body">
        <div class="wrap-narrow">
            <div class="article__section article__section--primary">
                @inertia
            </div><!-- .article__section -->
        </div><!-- .wrap-narrow -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection

@pushif($errors->any() || session()->has('error-message'), 'script')
<script>
    JT.confirm('{{ __("jt.CA-09") }}');
</script>
@endpushif
