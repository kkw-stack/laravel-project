<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ProfileRequest;
use App\Http\Requests\Front\WithdrawRequest;
use App\Models\User;
use App\Services\NiceApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class ProfileController extends Controller
{
    public function __construct(
        private NiceApiService $nice_service,
    ) {
        if (! $this->is_dev()) {
            abort(404);
        }
    }

    #[Get('member/profile', 'ko.member.profile', ['auth'])]
    #[Get('en/member/profile', 'en.member.profile', ['auth'])]
    public function profile(Request $request)
    {
        $user = $request->user('web');

        return view('front.member.profile', [
            'user' => $user,
            'nice_url' => $this->nice_service->url,
            'nice_data' => $this->nice_service->getFormData('member.profile.store.phone'),
        ]);
    }

    #[Post('member/profile', 'ko.member.profile.store', ['auth'])]
    #[Post('en/member/profile', 'en.member.profile.store', ['auth'])]
    public function store(ProfileRequest $request)
    {
        $request->handle();

        return $this->to_route('member.profile')->with('success-message', __('jt.ME-02'));
    }

    #[Get('member/profile/phone', 'ko.member.profile.store.phone', ['auth'])]
    #[Get('en/member/profile/phone', 'en.member.profile.store.phone', ['auth'])]
    public function store_phone(Request $request)
    {
        $nice_data = $request->session()->pull('nice_data');

        if (User::where('mobile', $nice_data['mobile'])->whereNot('id', $request->user('web')->id)->exists()) {
            return $this->to_route('member.profile')->with('error-message', __('jt.CA-08'));
        }

        $currentDate = new \DateTime();
        if ($currentDate->diff(new \DateTime($nice_data['birth']))->y < 14) {
            return $this->to_route('member.profile')->with('error-message', '만 14세 미만은 메덩골정원 회원이 <br />되실 수 없습니다.');
        }

        $request->user('web')->update($nice_data);

        return $this->to_route('member.profile')->with('success-message', __('jt.ME-02'));
    }

    #[Get('member/withdraw', 'ko.member.withdraw.form', ['auth'])]
    #[Get('en/member/withdraw', 'en.member.withdraw.form', ['auth'])]
    public function withdraw(Request $request)
    {
        return view('front.member.withdraw');
    }

    #[Post('member/withdraw', 'ko.member.withdraw.store', ['auth'])]
    #[Post('en/member/withdraw', 'en.member.withdraw.store', ['auth'])]
    public function withdraw_store(WithdrawRequest $request)
    {
        $user = $request->user('web');
        $data = [
            'withdraw' => 'etc' === $request->get('reason') ? '기타' : $request->get('reason'),
            'withdraw_memo' => 'etc' === $request->get('reason') ? $request->get('reason_etc') : '',
        ];

        $user->update($data);
        $user->delete();

        return $this->to_route('member.withdraw.success')->with('success', 1);
    }

    #[Get('member/withdraw/success', 'ko.member.withdraw.success', ['guest'])]
    #[Get('en/member/withdraw/success', 'en.member.withdraw.success', ['guest'])]
    public function withdraw_success(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        if (! $request->session()->has('success')) {
            return $this->to_route('index');
        }

        return view('front.member.withdraw-success');
    }
}
