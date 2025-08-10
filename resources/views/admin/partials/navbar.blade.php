<nav class="navbar">
    <button class="sidebar-toggler" type="button">
        <i data-feather="menu"></i>
    </button><!-- .sidebar-toggler -->

    <div class="navbar-content">
        <ul class="navbar-nav gap-4">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('ko.index') }}" target="_blank">
                    <i class="flag-icon flag-icon-kr mt-1" title="kr"></i>
                    <span class="ms-1 d-none d-md-inline-block">국문 사이트</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('en.index') }}" target="_blank">
                    <i class="flag-icon flag-icon-us mt-1" title="us"></i>
                    <span class="ms-1 d-none d-md-inline-block">영문 사이트</span>
                </a>
            </li>
        </ul><!-- .navbar-nav -->

        @if(auth('admin')->check())
            <ul class="navbar-nav gap-5 ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="wd-30 ht-30 rounded-circle" src="/assets/admin/images/profile.svg" alt="profile">
                    </a>

                    <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                        <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                            <div class="text-center">
                                <p class="tx-16 fw-bolder">{{ auth('admin')->user()->name }}</p>
                                <p class="tx-12 text-muted">{{ auth('admin')->user()->email }}</p>
                            </div>
                        </div>
                        <ul class="list-unstyled p-1">
                            <li class="dropdown-item py-2">
                                <a href="{{ route('admin.auth.logout') }}" class="text-body ms-0">
                                    <i class="me-2 icon-md" data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- .dropdown-menu -->
                </li>
            </ul><!-- .navbar-nav -->
        @endif
    </div><!-- .navbar-content -->
</nav><!-- .navbar -->
