@extends('front.partials.layout', [
    'view' => 'user-change-password',
    'seo_title' => 'Reset Password',
    'seo_description' => '',
])

@section('content')

<div class="article">
    <div class="article__header">
        <div class="wrap-thin">
            <h1 class="article__title jt-typo--02">Reset Password</h1>
        </div><!-- .wrap-thin -->
    </div><!-- .article__header -->

    <div class="article__body">
        <div class="article__section article__section--primary">
            <div class="wrap-thin">
                <h2 class="article__section-title jt-typo--06">{!! session('error-message') ?? 'Please enter your email address to receive a password reset URL.' !!}</h2>

                <form class="jt-form" method="post" novalidate>
                    @csrf

                    <fieldset class="jt-form__fieldset">
                        <div class="jt-form__entry jt-form--required">
                            <label class="jt-form__label" for="email"><span class="jt-typo--12">ID(E-mail)</span></label>
                            <div @class([
                                'jt-form__data',
                                'jt-form__data--error' => $errors->has('email'),
                            ])>
                                <input
                                    type="email"
                                    class="jt-form__field jt-form__field--valid"
                                    id="email"
                                    name="email"
                                    required
                                    placeholder="Please enter your email address"
                                />
                                <p class="jt-form__explain jt-typo--17">For help, contact <a href="mailto:@antispambot('medongaule@mdale.co.kr')">@antispambot('medongaule@mdale.co.kr')</a></p>
                                <p class="jt-form__valid jt-typo--17">@error('email'){{ $message }}@enderror</p>
                            </div><!-- .jt-form__data -->
                        </div><!-- .jt-form__entry -->
                    </fieldset><!-- .jt-form__fieldset -->

                    <div class="jt-form__control">
                        <button type="submit" class="jt-form__action"><span class="jt-typo--12">Reset Password</span></button>
                    </div><!-- .jt-form__control -->
                </form><!-- .jt-form -->
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection

@push('script')
<script>
    
    const form = document.querySelector('.jt-form');

    JT.globals.validation(form, {
        disable: true,
        on: {
            success: () => {
                form.submit();
            }
        }
    });

</script>
@endpush
