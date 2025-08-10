<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Auth\LoginRequest;
use App\Services\OAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class AuthController extends Controller
{
    public function __construct(
        private OAuthService $oauth_service,
    ) {
        if (! $this->is_dev()) {
            abort(404);
        }
    }

    #[Get('login', 'ko.login', ['guest'])]
    #[Get('en/login', 'en.login', ['guest'])]
    public function login(Request $request)
    {
        return view('front.auth.login', [
            'kakao_url' => $this->oauth_service->getKakaoLoginUrl(),
            'naver_url' => $this->oauth_service->getNaverLoginUrl(),
            'google_url' => $this->oauth_service->getGoogleLoginUrl(),
        ]);
    }

    #[Post('login', 'ko.login.store', ['guest'])]
    #[Post('en/login', 'en.login.store', ['guest'])]
    public function login_store(LoginRequest $request)
    {
        $request->handle();

        if ($request->query('redirect_to')) {
            return redirect($request->query('redirect_to'));
        }

        return $this->to_route('index');
    }

    #[Get('logout', 'ko.logout', ['auth'])]
    #[Get('en/logout', 'en.logout', ['auth'])]
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        return $this->to_route('index');
    }
}
