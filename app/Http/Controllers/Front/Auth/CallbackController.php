<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\NiceApiService;
use App\Services\OAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Get;

class CallbackController extends Controller
{
    public function __construct(
        private NiceApiService $nice_service,
        private OAuthService $oauth_service,
    ) {
        if (! $this->is_dev()) {
            abort(404);
        }
    }

    #[Get('auth/callback/nice', 'ko.auth.callback.nice')]
    #[Get('en/auth/callback/nice', 'en.auth.callback.nice')]
    public function nice(Request $request)
    {
        if (empty($request->query('enc_data'))) {
            abort(404);
        }

        $data = $this->nice_service->decrypt($request->query('enc_data'));
        $receivedata = null;

        if (! empty($data['receivedata'])) {
            parse_str($data['receivedata'], $receivedata);
        }

        if (empty($receivedata['callback'])) {
            abort(404);
        }

        $request->session()->put('nice_data', [
            'name' => $data['name'],
            'mobile' => preg_replace('/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/', '$1-$2-$3', $data['mobileno']),
            'gender' => $data['gender'],
            'birth' => \DateTime::createFromFormat('Ymd', $data['birthdate'])->format('Y-m-d'),
        ]);

        return "
        <script>
        if (window.opener) {
            window.opener.document.location.href = '{$receivedata['callback']}';
            window.close();
        } else {
            document.location.href = '{$receivedata['callback']}';
        }
        </script>
        ";
    }

    #[Get('auth/callback/kakao', 'ko.auth.callback.kakao')]
    #[Get('en/auth/callback/kakao', 'en.auth.callback.kakao')]
    public function kakao(Request $request)
    {
        $code = $request->query('code');

        if (empty($code)) {
            abort(404);
        }

        $data = $this->oauth_service->getKakaoData($code);

        if (! empty($data['kakao_id']) && ! empty($data['mobile'])) {
            $user = User::where('mobile', $data['mobile'])->first();

            if ($user) {
                Auth::login($user);

                $args = [
                    'last_logged_in' => date('Y-m-d H:i:s'),
                ];

                if (! $user->kakao_id) {
                    $args['kakao_id'] = $data['kakao_id'];
                    $args['kakao_connected'] = $args['last_logged_in'];
                }
                $user->update($args);

                return $this->to_route('index');
            }


            $request->session()->put([
                'kakao_id' => $data['kakao_id'],
                'social_email' => $data['email'],
            ]);
        }

        return $this->to_route('auth.register');
    }

    #[Get('auth/callback/naver', 'ko.auth.callback.naver')]
    #[Get('en/auth/callback/naver', 'en.auth.callback.naver')]
    public function naver(Request $request)
    {
        $code = $request->query('code');

        if (empty($code)) {
            abort(404);
        }

        $data = $this->oauth_service->getNaverData($code);

        if (! empty($data['naver_id']) && ! empty($data['mobile'])) {
            $user = User::where('mobile', $data['mobile'])->first();

            if ($user) {
                Auth::login($user);

                $args = [
                    'last_logged_in' => date('Y-m-d H:i:s'),
                ];

                if (! $user->naver_id) {
                    $args['naver_id'] = $data['naver_id'];
                    $args['naver_connected'] = $args['last_logged_in'];
                }
                $user->update($args);

                return $this->to_route('index');
            }

            $request->session()->put([
                'naver_id' => $data['naver_id'],
                'social_email' => $data['email'],
            ]);
        }

        return $this->to_route('auth.register');
    }

    #[Get('auth/callback/google', 'ko.auth.callback.google')]
    #[Get('en/auth/callback/google', 'en.auth.callback.google')]
    public function google(Request $request)
    {
        $code = $request->query('code');

        if (empty($code)) {
            abort(404);
        }

        $data = $this->oauth_service->getGoogleData($code);

        if (! empty($data['google_id']) && ! empty($data['email'])) {
            $user = User::where('google_id', $data['google_id'])->first();

            if ($user) {
                Auth::login($user);

                $args = [
                    'last_logged_in' => now(),
                ];

                if (! $user->google_id) {
                    $args['google_id'] = $data['google_id'];
                    $args['google_connected'] = $args['last_logged_in'];
                }
                $user->update($args);

                return $this->to_route('index');
            }

            $request->session()->put([
                'google_id' => $data['google_id'],
                'social_email' => $data['email'],
            ]);
        }

        return $this->to_route('auth.register');
    }
}
