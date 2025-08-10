<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.home') }}" class="sidebar-brand">
            <svg width="257" height="38" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 257 38">
                <path d="M37.5,10.13A9.63,9.63,0,0,0,19,6.41,9.62,9.62,0,1,0,6.41,19,9.62,9.62,0,1,0,19,31.59,9.62,9.62,0,1,0,31.6,19,9.63,9.63,0,0,0,37.5,10.13ZM27.88,2a8.12,8.12,0,0,1,5.74,13.87,8.06,8.06,0,0,1-5.74,2.39H19.75V10.13A8.14,8.14,0,0,1,27.88,2Zm0,34a8.13,8.13,0,0,1-8.13-8.12V19.75h8.13a8.13,8.13,0,0,1,0,16.25ZM2,10.12a8.13,8.13,0,0,1,16.25,0v8.13H10.12A8.15,8.15,0,0,1,2,10.12ZM10.12,36a8.13,8.13,0,0,1,0-16.25h8.13v8.13A8.13,8.13,0,0,1,10.12,36Z" />
                <path d="M64.66 17.72L58.97 11.47L57 11.47L57 26.77L59.19 26.77L59.19 14.91L64.66 20.84L70.12 14.91L70.12 26.78L72.31 26.78L72.31 11.47L70.34 11.47L64.66 17.72z" />
                <path d="M80.59 26.79L92.62 26.79L92.62 24.71L82.78 24.71L82.78 20.11L89.67 20.11L89.67 18.03L82.78 18.03L82.78 13.55L92.62 13.55L92.62 11.47L80.59 11.47L80.59 26.79z" />
                <path d="M89.77 6L87.25 6L85.37 9.93L87.25 9.93L89.77 6z" />
                <path d="M107.16,11.47h-6.54V26.78h6.54a7.66,7.66,0,1,0,0-15.31Zm0,13.23h-4.35V13.55h4.35a5.36,5.36,0,0,1,5.38,5.57A5.37,5.37,0,0,1,107.16,24.7Z" />
                <path d="M128.53,11.25a7.88,7.88,0,1,0,7.88,7.87A7.9,7.9,0,0,0,128.53,11.25Zm0,13.67a5.63,5.63,0,0,1-5.6-5.8,5.6,5.6,0,1,1,11.2,0A5.62,5.62,0,0,1,128.52,24.92Z" />
                <path d="M154.48 23.15L145.51 11.47L143.43 11.47L143.43 26.78L145.62 26.78L145.62 15.1L154.59 26.78L156.67 26.78L156.67 11.47L154.48 11.47L154.48 23.15z" />
                <path d="M171.58,20.15h5.6a5.63,5.63,0,0,1-11.2-1,5.62,5.62,0,0,1,5.6-5.79,5.26,5.26,0,0,1,4,1.79l1.55-1.55a7.85,7.85,0,1,0,2.33,5.55V18.07h-7.88Z" />
                <path d="M197,20.15h0l-3.89-8.68h-2.24L184,26.77h2.36l2-4.55h7.16l2,4.55h2.38L197,20.21Zm-7.69,0,2.66-6,2.65,6Z" />
                <path d="M216.32,20.41a4.43,4.43,0,1,1-8.85,0V11.47h-2.19v9a6.62,6.62,0,0,0,13.23,0v-9h-2.19Z" />
                <path d="M228.79 11.47L226.6 11.47L226.6 26.78L238.63 26.78L238.63 24.7L228.79 24.7L228.79 11.47z" />
                <path d="M257 13.55L257 11.47L244.97 11.47L244.97 26.79L257 26.79L257 24.71L247.16 24.71L247.16 20.11L254.04 20.11L254.04 18.03L247.16 18.03L247.16 13.55L257 13.55z" />
            </svg>
        </a><!-- .sidebar-brand -->

        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div><!-- .sidebar-toggler -->
    </div><!-- .sidebar-header -->

    <div class="sidebar-body">
        <ul class="nav">
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.reservation.manage.list'),
                ])
            >
                <a href="{{ route('admin.reservation.manage.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="check-square"></i>
                    <span class="link-title">관람권 사용 관리</span>
                </a>
            </li>

            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.statics.*'),
                ])
            >
                <a href="{{ route('admin.statics.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="bar-chart"></i>
                    <span class="link-title">통계화면</span>
                </a>
            </li>

            <li class="nav-item nav-category">메인 관리</li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.main.visual.*'),
                ])
            >
                <a href="{{ route('admin.main.visual.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="film"></i>
                    <span class="link-title">비주얼 슬라이드</span>
                </a>
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.main.feed.*'),
                ])
            >
                <a href="{{ route('admin.main.feed.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="send"></i>
                    <span class="link-title">메덩골 소식</span>
                </a>
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.main.scenery.*'),
                ])
            >
                <a href="{{ route('admin.main.scenery.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="camera"></i>
                    <span class="link-title">메덩골 풍경</span>
                </a>
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.main.popup.*'),
                ])
            >
                <a href="{{ route('admin.main.popup.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">팝업</span>
                </a>
            </li>

            <li class="nav-item nav-category">소개 관리</li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.intro.history.*'),
                ])
            >
                <a class="nav-link" data-bs-toggle="collapse" href="#nav-history" aria-controls="nav-history" role="button" aria-expanded="false">
                    <i class="link-icon" data-feather="git-merge"></i>
                    <span class="link-title">걸어온 길</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a><!-- .nav-link -->
                <div
                    id="nav-history"
                    @class([
                        'collapse',
                        'show' => request()->routeIs('admin.intro.history.*'),
                    ])
                >
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.intro.history.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.intro.history.*') && !request()->routeIs('admin.intro.history.category.*'),
                                ])
                            >모든 걸어온 길</a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.intro.history.category.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.intro.history.category.*'),
                                ])
                            >카테고리</a>
                        </li>
                    </ul><!-- .sub-menu -->
                </div><!-- .collapse -->
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.intro.people.*'),
                ])
            >

                <a class="nav-link" data-bs-toggle="collapse" href="#nav-people" aria-controls="nav-people" role="button" aria-expanded="false">
                    <i class="link-icon" data-feather="smile"></i>
                    <span class="link-title">함께한 사람들</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a><!-- .nav-link -->
                <div
                    id="nav-people"
                    @class([
                        'collapse',
                        'show' => request()->routeIs('admin.intro.people.*'),
                    ])
                >

                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.intro.people.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.intro.people.*') && !request()->routeIs('admin.intro.people.category.*'),
                                ])
                            >모든 함께한 사람들</a>

                        </li>
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.intro.people.category.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.intro.people.category.*'),
                                ])
                            >카테고리</a>
                        </li>
                    </ul><!-- .sub-menu -->
                </div><!-- .collapse -->
            </li>

            <li class="nav-item nav-category">정원 관리</li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.garden.hanguk.*'),
                ])
            >
                <a class="nav-link" data-bs-toggle="collapse" href="#nav-hanguk-garden" aria-controls="nav-hanguk-garden" role="button" aria-expanded="false">
                    <i class="link-icon" data-feather="image"></i>
                    <span class="link-title">한국정원</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a><!-- .nav-link -->
                <div
                    id="nav-hanguk-garden"
                    @class([
                        'collapse',
                        'show' => request()->routeIs('admin.garden.hanguk.*'),
                    ])
                >
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.garden.hanguk.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.garden.hanguk.*') && !request()->routeIs('admin.garden.hanguk.category.*') && !request()->routeIs('admin.garden.hanguk.feed.*'),
                                ])
                            >모든 한국정원</a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.garden.hanguk.category.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.garden.hanguk.category.*'),
                                ])
                            >카테고리</a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.garden.hanguk.feed.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.garden.hanguk.feed.*'),
                                ])
                            >한국정원 소식</a>
                        </li>
                    </ul><!-- .sub-menu -->
                </div><!-- .collapse -->
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#nav-modern-garden" aria-controls="nav-modern-garden" role="button" aria-expanded="false">
                    <i class="link-icon" data-feather="image"></i>
                    <span class="link-title">현대정원</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a><!-- .nav-link -->
                <div id="nav-modern-garden" class="collapse">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">모든 현대정원</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">카테고리</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">현대정원 소식</a>
                        </li>
                    </ul><!-- .sub-menu -->
                </div><!-- .collapse -->
            </li>

            <li class="nav-item nav-category">예매 관리</li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.reservation.*') && !request()->routeIs('admin.reservation.manage.list'),
                ])
            >
                <a href="{{ route('admin.reservation.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="shopping-bag"></i>
                    <span class="link-title">예매정보</span>
                </a>
            </li>

            <li class="nav-item nav-category">회원 관리</li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.member.*'),
                ])
            >
                <a href="{{ route('admin.member.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">회원정보</span>
                </a>
            </li>

            <li class="nav-item nav-category">티켓 관리</li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.ticket.*') && !request()->routeIs('admin.ticket.config'),
                ])
            >
                <a href="{{ route('admin.ticket.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="tag"></i>
                    <span class="link-title">티켓정보</span>
                </a>
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.ticket.config'),
                ])
            >
                <a href="{{ route('admin.ticket.config') }}" class="nav-link">
                    <i class="link-icon" data-feather="settings"></i>
                    <span class="link-title">공통 정보관리</span>
                </a>
            </li>

            <li class="nav-item nav-category">새소식 관리</li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.notice.*'),
                ])
            >
                <a href="{{ route('admin.notice.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="bell"></i>
                    <span class="link-title">공지</span>
                </a>
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.news.*'),
                ])
            >
                <a href="{{ route('admin.news.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="radio"></i>
                    <span class="link-title">언론뉴스</span>
                </a>
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.event.*'),
                ])
            >
                <a href="{{ route('admin.event.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">행사</span>
                </a>
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.scenery.*'),
                ])
            >
                <a class="nav-link" data-bs-toggle="collapse" href="#nav-scenery" aria-controls="nav-scenery" role="button" aria-expanded="false">
                    <i class="link-icon" data-feather="camera"></i>
                    <span class="link-title">메덩골 풍경</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a><!-- .nav-link -->
                <div
                    id="nav-scenery"
                    @class([
                        'collapse',
                        'show' => request()->routeIs('admin.scenery.*'),
                    ])
                >
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.scenery.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.scenery.*') && !request()->routeIs('admin.scenery.category.*'),
                                ])
                            >메덩골 풍경</a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.scenery.category.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.scenery.category.*'),
                                ])
                            >카테고리</a>
                        </li>
                    </ul><!-- .sub-menu -->
                </div><!-- .collapse -->
            </li>
            <li class="nav-item nav-category">이용안내 관리</li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.guide.visitor.*'),
                ])
            >
                <a href="{{ route('admin.guide.visitor.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="info"></i>
                    <span class="link-title">관람안내</span>
                </a>
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.faq.*'),
                ])
            >
                <a class="nav-link" data-bs-toggle="collapse" href="#nav-faq" aria-controls="nav-faq" role="button" aria-expanded="false">
                    <i class="link-icon" data-feather="help-circle"></i>
                    <span class="link-title">자주묻는질문</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a><!-- .nav-link -->
                <div
                    id="nav-faq"
                    @class([
                        'collapse',
                        'show' => request()->routeIs('admin.faq.*'),
                    ])
                >
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.faq.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.faq.*') && !request()->routeIs('admin.faq.category.*'),
                                ])
                            >모든 자주묻는질문</a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="{{ route('admin.faq.category.list') }}"
                                @class([
                                    'nav-link',
                                    'active' => request()->routeIs('admin.faq.category.*'),
                                ])
                            >카테고리</a>
                        </li>
                    </ul><!-- .sub-menu -->
                </div><!-- .collapse -->
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.intro.attractions.*'),
                ])
            >
                <a href="{{ route('admin.intro.attractions.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="map"></i>
                    <span class="link-title">주변 볼거리</span>
                </a>
            </li>

            <li class="nav-item nav-category">약관 관리</li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.privacy.*'),
                ])
            >
                <a href="{{ route('admin.privacy.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title">개인정보처리방침</span>
                </a>
            </li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.service.*'),
                ])
            >
                <a href="{{ route('admin.service.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title">서비스 이용약관</span>
                </a>
            </li>

            <li class="nav-item nav-category">관리자 관리</li>
            <li
                @class([
                    'nav-item',
                    'active' => request()->routeIs('admin.manager.*'),
                ])
            >
                <a href="{{ route('admin.manager.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">관리자 정보</span>
                </a>
            </li>
        </ul><!-- .nav -->
    </div><!-- .sidebar-body -->
</nav><!-- .sidebar -->
