<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Auth\ForgotPasswordRequest;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Middleware(['guest:admin'])]
#[Prefix('auth')]
class AdminLoginController extends Controller
{
    #[Get('login', 'admin.auth.login')]
    public function login(Request $request)
    {
        return view('admin.auth.login');
    }

    #[Post('login', 'admin.auth.login-action')]
    public function handle_login(LoginRequest $request)
    {
        $request->handle();

        return to_route('admin.home');
    }

    #[Get('forgot-password', 'admin.auth.forgot-password')]
    #[Get('forgot-password-complete', 'admin.auth.forgot-password-complete')]
    public function forgotPassword(Request $request)
    {
        return view('admin.auth.forgot-password');
    }

    #[Post('forgot-password', 'admin.auth.forgot-password-action')]
    public function handle_forgot_password(ForgotPasswordRequest $request)
    {
        $request->handle();

        return to_route('admin.auth.forgot-password-complete');
    }

    #[Get('reset-password/{token}', 'admin.auth.reset-password')]
    #[Get('reset-password-complete', 'admin.auth.reset-password-complete')]
    public function reset_password(Request $request)
    {
        return view('admin.auth.reset-password');
    }

    #[Post('reset-password/{token}', 'admin.auth.reset-password-action')]
    public function handleResetPassword(ResetPasswordRequest $request)
    {
        $request->handle();

        return to_route('admin.auth.reset-password-complete');
    }
}
