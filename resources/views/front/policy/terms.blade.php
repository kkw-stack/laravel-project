@extends('front.partials.layout', [
    'view' => 'manual-policy-terms',
    'seo_title' => __('front.terms.title'),
    'seo_description' => __('front.desc.terms'),
])

@section('content')
<div class="jt-single">
    <div class="jt-single__inner">
        <div class="jt-single__header">
            <div class="jt-single__title-wrap">
                <h1 class="jt-single__title jt-typo--02">{!! __('front.terms.title') !!}</h1>

                @if($services->count() > 0)
                    <div class="jt-single__select">
                        <div class="jt-choices__wrap">
                            <select class="jt-choices" name="term">
                                @foreach($services as $item)
                                    <option value="{{ url()->current() }}?term={{ $item->id }}" @selected($item->id == $service?->id)>{{ $item->title }}</option>
                                @endforeach
                            </select><!-- .jt-choices -->
                        </div><!-- .jt-choices__wrap -->
                    </div><!-- .jt-single__select -->
                @endif
            </div><!-- .jt-single__title-wrap -->
        </div><!-- .jt-single__header -->

        <div class="jt-single__body">
            <div class="jt-single__content">
                @if(!empty($service))
                    {!! content($service?->content) !!}
                @else
                    @include('front.partials.empty')
                @endif
            </div><!-- .jt-single__content -->
        </div><!-- .jt-single__body -->
    </div><!-- .jt-single__inner -->
</div><!-- .jt-single -->
@endsection
