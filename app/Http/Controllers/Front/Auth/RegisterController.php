<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Auth\MemberRegisterRequest;
use App\Models\User;
use App\Services\NiceApiService;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;

#[Middleware(['guest'])]
class RegisterController extends Controller
{
    public function __construct(
        private NiceApiService $nice_service,
    ) {
        if (! $this->is_dev()) {
            abort(404);
        }
    }

    #[Get('auth/register', 'ko.auth.register')]
    #[Get('en/auth/register', 'en.auth.register')]
    public function agree(Request $request)
    {
        if ($request->session()->has('nice_data')) {
            $request->session()->remove('nice_data');
        }

        return view('front.auth.member.agree', [
            'nice_url' => $this->nice_service->url,
            'nice_data' => $this->nice_service->getFormData('auth.register.create'),
        ]);
    }

    #[Get('auth/register/create', 'ko.auth.register.create')]
    #[Get('en/auth/register/create', 'en.auth.register.create')]
    public function create(Request $request)
    {
        $nice_data = $request->session()->get('nice_data');
        $social_email = $request->session()->get('social_email');

        if (app()->getLocale() === 'en') {
            return view('front.auth.member.form', compact('social_email'));
        }

        if (empty($nice_data)) {
            return $this->to_route('auth.register');
        }

        if (User::withTrashed()->where('mobile', $nice_data['mobile'])->exists()) {
            $user = User::withTrashed()->where('mobile', $nice_data['mobile'])->first();

            if ($user->trashed()) {
                return view('front.auth.member.error', [
                    'title' => '탈퇴 후 30일 동안 재가입이 불가능합니다.',
                    'description' => '다른 휴대폰번호를 통해 인증을 진행해주세요.',
                    'nice_url' => $this->nice_service->url,
                    'nice_data' => $this->nice_service->getFormData('auth.register.create'),
                ]);
            }

            return $this->to_route('auth.register.history')->with('exist_user', $user);
        }

        $currentDate = new \DateTime();
        if ($currentDate->diff(new \DateTime($nice_data['birth']))->y < 14) {
            return view('front.auth.member.error', [
                'title' => '만 14세 미만인 경우 회원가입이 불가합니다.',
                'description' => '개인정보보호법에 따라 메덩골정원은 만 14세 이상부터 가입이 가능합니다.',
                'nice_url' => $this->nice_service->url,
                'nice_data' => $this->nice_service->getFormData('auth.register.create'),
            ]);
        }

        return view('front.auth.member.form', compact('nice_data', 'social_email'));
    }

    #[Post('auth/register/create', 'ko.auth.register.store')]
    #[Post('en/auth/register/create', 'en.auth.register.store')]
    public function store(MemberRegisterRequest $request)
    {
        $user = $request->handle();

        return $this->to_route('auth.register.success')->with('registered_user', $user);
    }

    #[Get('auth/register/success', 'ko.auth.register.success')]
    #[Get('en/auth/register/success', 'en.auth.register.success')]
    public function success(Request $request)
    {
        if (! $request->session()->has('registered_user')) {
            return $this->to_route('auth.register');
        }

        $request->session()->keep('registered_user');

        return view('front.auth.member.success', [
            'user' => $request->session()->get('registered_user'),
        ]);
    }

    #[Get('auth/register/history', 'ko.auth.register.history')]
    #[Get('en/auth/register/history', 'en.auth.register.history')]
    public function history(Request $request)
    {
        if (! $request->session()->has('exist_user')) {
            return $this->to_route('auth.register');
        }

        $request->session()->keep('exist_user');

        return view('front.auth.member.history', [
            'user' => $request->session()->get('exist_user'),
        ]);
    }
}
