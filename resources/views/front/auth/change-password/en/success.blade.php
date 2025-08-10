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
                @include('front.partials.take', [
                    'title' => 'Congratulations, your password has been <br />successfully changed.',
                    'desc' => 'Log in now with your new password.',
                    'link' => [
                        'href' => jt_route('login'),
                        'text' => 'Login',
                        'nobarba' => '1'
                    ]
                ])
            </div><!-- .wrap-thin -->
        </div><!-- .article__section -->
    </div><!-- .article__body -->
</div><!-- .article -->
@endsection
