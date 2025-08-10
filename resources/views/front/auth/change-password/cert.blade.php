@extends('front.partials.layout', [
    'view' => 'user-change-password',
    'seo_title' => '비밀번호 재설정',
    'seo_description' => '',
])

@section('content')
<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">비밀번호 재설정</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                <div class="jt-take">
                    <b class="jt-typo--06">비밀번호를 다시 설정해주세요.</b>
                    <p class="jt-typo--13">비밀번호는 암호화되어 확인할 수 없으며, 본인인증을 통해 <br />재설정 하실 수 있습니다.</p>

                    <div class="jt-take__controls">
                        <form data-action="{{ $nice_url }}" class="jt-form" novalidate>
                            @foreach($nice_data as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                            @endforeach

                            <button type="submit" class="jt-form__action"><span class="jt-typo--12">본인인증 하기</span></button>
                        </form><!-- .jt-form -->
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
