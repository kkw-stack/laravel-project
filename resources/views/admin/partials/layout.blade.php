@php
    $version = "1.0.2";
@endphp
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="robots" content="noindex, nofollow" />

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Favicon -->
    <link rel="icon" href="/assets/admin/images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" href="/assets/admin/images/favicon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="/assets/admin/images/favicon-180x180.png" />
    <meta name="msapplication-TileImage" content="/assets/admin/images/favicon-270x270.png" />

	<title>{{ $title ?? '' }} | 메덩골 관리자</title>

    <!-- core:css -->
    <link rel="stylesheet" href="/assets/admin/vendors/core/core.css">
    <!-- endinject -->

    <!-- Plugin css -->
    <link rel="stylesheet" href="/assets/admin/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/admin/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/admin/vendors/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="/assets/admin/vendors/fullcalendar/main.min.css">
    <!-- End plugin css -->

    <!-- inject:css -->
    <link rel="stylesheet" href="/assets/admin/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="/assets/admin/vendors/flag-icon-css/css/flag-icon.min.css">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/admin/css/font.css?v={{ $version }}">
    <link rel="stylesheet" href="/assets/admin/css/style.css?v={{ $version }}">
    <!-- End layout styles -->

    <!-- Custom css -->
    <link rel="stylesheet" href="/assets/admin/css/custom.css?v={{ $version }}">
    <!-- End custom css -->
</head>
<body>
    <div class="main-wrapper">
        @if ( isset($type) && $type == 'primary' )
            @include("admin.partials.sidebar")

            <div class="page-wrapper">
                @include("admin.partials.navbar")

                <div class="page-content">
                    @include('admin.partials.messages')

                    @yield("content")
                </div><!-- .page-content -->

                @include("admin.partials.footer")
            </div><!-- .page-wrapper -->
        @else
            <div class="page-wrapper full-page">
			    <div class="page-content d-flex align-items-center justify-content-center">
                    @include('admin.partials.messages')

                    @yield("content")
                </div><!-- .page-content -->
            </div><!-- .page-wrapper -->
        @endif
    </div><!-- .main-wrapper -->

    <!-- core:js -->
	<script src="/assets/admin/vendors/core/core.js"></script>
	<!-- endcore -->

    <!-- Plugin js -->
    <script src="/assets/admin/vendors/sortablejs/Sortable.min.js"></script>
    <script src="/assets/admin/vendors/tinymce/tinymce.min.js"></script>
    <script src="/assets/admin/vendors/select2/select2.min.js"></script>
    <script src="/assets/admin/vendors/flatpickr/flatpickr.min.js"></script>
    <script src="/assets/admin/vendors/flatpickr/l10n/ko.js"></script>
    <script src="/assets/admin/vendors/fullcalendar/main.min.js"></script>
    <script src="/assets/admin/vendors/fullcalendar/locales/ko.global.min.js"></script>
    <script src="/assets/admin/vendors/dayjs/dayjs.min.js"></script>
    <script src="/assets/admin/vendors/dayjs/locale/ko.js"></script>
    <script src="/assets/admin/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/admin/vendors/jt/jt-customfile.js"></script>
    <!-- End plugin js -->

    <!-- inject:js -->
    <script src="/assets/admin/vendors/feather-icons/feather.min.js"></script>
    <script src="/assets/admin/js/template.js"></script>
    <!-- endinject -->

    <!-- Custom js -->
    <script src="/assets/admin/js/custom.js?v={{ $version }}"></script>
    @stack("scripts")
    <!-- End custom js -->

    <script>
    // 세션 유지를 위한 백그라운드 요청
    setInterval(function () {
        fetch('/up').then(response => {});
    }, 60000);
    </script>
</body>
</html>
