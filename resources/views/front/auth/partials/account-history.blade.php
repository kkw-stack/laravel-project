<div class="jt-register-history__list">
    <div class="jt-register-history__item jt-register-history__item--email">
        <div class="jt-register-history__item-title">
            <span class="jt-register-history__item-icon">
                <i class="jt-icon">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M20.47,5.05A1.67,1.67,0,0,0,19.2,4.5H4.8a1.67,1.67,0,0,0-1.27.55A1.87,1.87,0,0,0,3,6.38V17.62A1.87,1.87,0,0,0,3.53,19a1.67,1.67,0,0,0,1.27.55H19.2A1.67,1.67,0,0,0,20.47,19,1.87,1.87,0,0,0,21,17.62V6.38A1.87,1.87,0,0,0,20.47,5.05ZM19.2,8.25,12,12.94,4.8,8.25V6.38L12,11.06l7.2-4.68Z"/>
                    </svg>
                </i><!-- .jt-icon -->
            </span><!-- .jt-register-history__item-icon -->
            <b class="jt-typo--13">@antispambot($user->email)</b>
        </div><!-- .jt-register-history__item-title -->

        <time class="jt-typo--15" datetime="{{ $user->created_at->format('Y-m-d') }}">{!! __('front.register.success.date', ['DATE'=>$user->created_at->format('Y. m. d')]) !!}</time>
    </div><!-- .jt-register-history__item -->

    @if($user->kakao_id)
        <div class="jt-register-history__item jt-register-history__item--kakao">
            <div class="jt-register-history__item-title">
                <span class="jt-register-history__item-icon">
                    <i class="jt-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.0482 4C7.33195 4 3.5 7.1 3.5 10.9C3.5 13.3 5.07208 15.4 7.33195 16.7L6.74242 20L10.3779 17.6C10.8691 17.7 11.4587 17.7 11.9499 17.7C16.6662 17.7 20.4982 14.6 20.4982 10.8C20.5964 7.1 16.7645 4 12.0482 4Z" />
                        </svg>
                    </i><!-- .jt-icon -->
                </span><!-- .jt-register-history__item-icon -->
                <b class="jt-typo--13">카카오 간편로그인</b>
            </div><!-- .jt-register-history__item-title -->

            <time class="jt-typo--15" datetime="{{ $user->kakao_connected->format('Y-m-d') }}">{!! __('front.register.success.date', ['DATE'=>$user->kakao_connected->format('Y. m. d')]) !!}</time>
        </div><!-- .jt-register-history__item -->
    @endif

    @if($user->naver_id)
        <div class="jt-register-history__item jt-register-history__item--naver">
            <div class="jt-register-history__item-title">
                <span class="jt-register-history__item-icon">
                    <i class="jt-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.6817 4.5V12.1271L9.31831 4.5H3.5625V19.5H9.31831V12L14.6817 19.5H20.4375V4.5H14.6817Z"/>
                        </svg>
                    </i><!-- .jt-icon -->
                </span><!-- .jt-register-history__item-icon -->
                <b class="jt-typo--13">네이버 간편로그인</b>
            </div><!-- .jt-register-history__item-title -->

            <time class="jt-typo--15" datetime="{{ $user->naver_connected->format('Y-m-d') }}">{!! __('front.register.success.date', ['DATE'=>$user->naver_connected->format('Y. m. d')]) !!}</time>
        </div><!-- .jt-register-history__item -->
    @endif
    @if($user->google_id)
        <div class="jt-register-history__item jt-register-history__item--google">
            <div class="jt-register-history__item-title">
                <span class="jt-register-history__item-icon">
                    <i class="jt-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.9435 12.1459C21.9435 11.4426 21.8804 10.7664 21.7632 10.1172H12.4219V13.9538H17.7598C17.5298 15.1936 16.831 16.244 15.7806 16.9473V19.4359H18.986C20.8615 17.7092 21.9435 15.1665 21.9435 12.1459Z" fill="#4285F4"/>
                            <path d="M12.4259 21.8386C15.1039 21.8386 17.349 20.9504 18.9901 19.4356L15.7846 16.947C14.8965 17.5421 13.7604 17.8938 12.4259 17.8938C9.84263 17.8938 7.65608 16.149 6.87614 13.8047H3.5625V16.3744C5.19452 19.616 8.54873 21.8386 12.4259 21.8386Z" fill="#34A853"/>
                            <path d="M6.86859 13.7997C6.67022 13.2046 6.55752 12.5689 6.55752 11.9152C6.55752 11.2615 6.67022 10.6258 6.86859 10.0307V7.46094H3.55495C2.88321 8.79992 2.5 10.3147 2.5 11.9152C2.5 13.5157 2.88321 15.0305 3.55495 16.3694L6.86859 13.7997Z" fill="#FBBC05"/>
                            <path d="M12.4259 5.94481C13.8821 5.94481 15.1895 6.44523 16.2174 7.42805L19.0622 4.58328C17.3445 2.98282 15.0994 2 12.4259 2C8.54873 2 5.19452 4.22262 3.5625 7.46412L6.87614 10.0339C7.65608 7.68954 9.84263 5.94481 12.4259 5.94481Z" fill="#EA4335"/>
                        </svg>
                    </i><!-- .jt-icon -->
                </span><!-- .jt-register-history__item-icon -->
                <b class="jt-typo--13">Google Account</b>
            </div><!-- .jt-register-history__item-title -->

            <time class="jt-typo--15" datetime="{{ $user->google_connected->format('Y-m-d') }}">{!! __('front.register.success.date', ['DATE'=>$user->google_connected->format('Y. m. d')]) !!}</time>
        </div><!-- .jt-register-history__item -->
    @endif
</div><!-- .jt-register-history__list -->
