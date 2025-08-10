<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a
            @class([
                'nav-link',
                'active' => 'ko' === $locale,
            ])
            href="{{ route($route) }}"
        >
            국문
        </a>
    </li>
    <li class="nav-item">
        <a
            @class([
                'nav-link',
                'active' => 'en' === $locale,
            ])
            href="{{ route($route, ['locale' => 'en']) }}"
        >
            영문
        </a>
    </li>
</ul><!-- .nav-tabs -->
