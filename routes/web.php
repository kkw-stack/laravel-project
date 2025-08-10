<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

$isDev = config('app.env', 'production') === 'development';

// 관리자 홈 >> 관람권 사용 관리
Route::get(JT_ADMIN_PREFIX, fn () => to_route('admin.reservation.manage.list'))->name('admin.home');

/**
 * 개발용 resources/views 라우팅 연동
 * 데이터 연동이 완료되면 삭제해주세요.
 */
if ($isDev) {
    Route::get('react/{path?}', function (string $path = '') {
        $view = '';
        if (file_exists(resource_path("js/pages/{$path}.jsx"))) {
            $view = str_replace('/', '.', trim($path, '/'));
        }
        if (empty($view)) {
            abort(404);
        }

        return Inertia::render($view);
    })->where('path', '.*');

    Route::get('{path?}', function (string $path = '') {
        if (file_exists(resource_path("views/{$path}.blade.php"))) {
            return view(str_replace('/', '.', trim($path, '/')));
        } elseif (file_exists(resource_path("views/{$path}/index.blade.php"))) {
            return view(str_replace('/', '.', trim($path . '/index', '/')));
        }
        abort(404);
    })->where('path', '.*');
}
