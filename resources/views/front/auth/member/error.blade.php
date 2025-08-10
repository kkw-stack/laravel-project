@extends('front.partials.layout', [
    'view' => 'register-impossible',
    'seo_title' => '회원정보 입력',
    'seo_description' => '',
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">회원정보 입력</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">

        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                <div class="jt-take">
                    <b class="jt-typo--06">{{ $title }}</b>
                    <p class="jt-typo--13">{{ $description }}</p>

                    <div class="jt-take__controls">
                        <form data-action="{{ $nice_url }}" class="jt-form" novalidate method="POST">
                            @foreach($nice_data as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                            @endforeach

                            <button type="submit" class="jt-form__action"><span class="jt-typo--12">본인인증 하기</span></button>
                        </form>
                    </div><!-- .jt-take__controls -->
                </div><!-- .jt-take -->
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection

@push('script')
<script>

    const form = document.querySelector('.jt-form');

    JT.globals.validation(form, {
        on: {
            success: () => {
                const formData = new FormData(form);
                const queryString = new URLSearchParams(formData).toString();
                const url = form.dataset.action + (queryString.length > 0 ? '?' + queryString : '');

                JT.globals.popupWin(url, {
                    title: 'niceapi',
                    width: 480,
                    height: 800
                });
            }
        }
    });

</script>
@endpush
