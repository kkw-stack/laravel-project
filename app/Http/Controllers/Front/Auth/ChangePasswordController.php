<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Auth\ChangePasswordRequest;
use App\Models\User;
use App\Services\NiceApiService;
use App\Models\PasswordResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class ChangePasswordController extends Controller
{
    public function __construct(
        private NiceApiService $nice_service,
    ) {
        if (! $this->is_dev()) {
            abort(404);
        }
    }

    #[Get('auth/change-password', 'ko.auth.change-password')]
    #[Get('en/auth/change-password', 'en.auth.change-password')]
    public function index(Request $request)
    {
        if ($request->session()->has('change_password_user')) {
            $request->session()->remove('change_password_user');
        }

        if (app()->getLocale() === 'en') {
            return view('front.auth.change-password.en.cert');
        }

        if ($request->session()->has('nice_data')) {
            $nice_data = $request->session()->pull('nice_data');
            $user = User::where('mobile', $nice_data['mobile'])->first();

            if ($user) {
                $request->session()->flash('nice_data', $nice_data);
                $request->session()->put('change_password_user', $user);

                return view('front.auth.change-password.form', [
                    'user' => $request->session()->get('change_password_user'),
                ]);
            }
            
            return view('front.auth.change-password.error');
        }

        return view('front.auth.change-password.cert', [
            'nice_url' => $this->nice_service->url,
            'nice_data' => $this->nice_service->getFormData('auth.change-password'),
        ]);
    }


    #[Post('auth/change-password', 'ko.auth.change-password')]
    #[Post('en/auth/change-password', 'en.auth.change-password')]
    public function store(ChangePasswordRequest $request)
    {
        if (app()->getLocale() === 'en') {
            $email = $request->input('email');
            $user = $email ? $request->findUserByEmail($email) : null;
    
            if (! $user) {
                return back()->withErrors(['email' => __('jt.IN-06')]);
            }
    
            $request->session()->put('change_password_email', $user->email);
            $request->sendMail();
    
            return view('front.auth.change-password.en.sent');
        }

        $request->handle();

        return $this->to_route('auth.change-password.success')->with('change_password_result', $request->session()->pull('change_password_user'));
    }
    

    #[Get('auth/change-password/success', 'ko.auth.change-password.success')]
    #[Get('en/auth/change-password/success', 'en.auth.change-password.success')]
    public function success(Request $request)
    {
        if (! $request->session()->has('change_password_result')) {
            return $this->to_route('auth.change-password');
        }

        $request->session()->keep('change_password_result');

        return view('front.auth.change-password.success');
    }

    #[Get('en/auth/change-password/{token}/{email}', 'en.auth.change-password.form')]
    public function change_password(Request $request, $token)
    {
        if (! PasswordResetToken::findByTokenAndValidate($token)) {
            return $this->to_route('auth.change-password')->with('error-message', 'The password reset link has expired. Please try again. Enter your email address to receive a new password reset link.');
        }

        return view('front.auth.change-password.en.form');
    }


    #[Post('en/auth/change-password/{token}/{email}', 'en.auth.change-password.success')]
    public function handleChangePassword(ChangePasswordRequest $request, $token)
    {
        if (! PasswordResetToken::findByTokenAndValidate($token)) {
            return $this->to_route('auth.change-password')->with('error-message', 'The password reset link has expired. Please try again. Enter your email address to receive a new password reset link.');
        }

        $request->changePassword();
        $request->session()->pull('change_password_email');
        
        return view('front.auth.change-password.en.success');
    }
}
