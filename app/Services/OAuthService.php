<?php

namespace App\Services;

use DateTime;
use Illuminate\Support\Facades\Http;

class OAuthService extends Service
{
    private ?string $kakao_client_id;
    private ?string $kakao_secret;
    private ?string $naver_client_id;
    private ?string $naver_secret;
    private ?string $google_client_id;
    private ?string $google_secret;

    public function __construct()
    {
        $this->kakao_client_id = config('jt.kakao_client_id');
        $this->kakao_secret = config('jt.kakao_secret');
        $this->naver_client_id = config('jt.naver_client_id');
        $this->naver_secret = config('jt.naver_secret');
        $this->google_client_id = config('jt.google_client_id');
        $this->google_secret = config('jt.google_secret');
    }

    public function getKakaoLoginUrl()
    {
        if (empty($this->kakao_client_id)) {
            return '';
        }

        return 'https://kauth.kakao.com/oauth/authorize?' . http_build_query([
            'client_id' => $this->kakao_client_id,
            'response_type' => 'code',
            'redirect_uri' => jt_route('auth.callback.kakao'),
        ]);
    }

    public function getKakaoData(string $code)
    {
        if (empty($this->kakao_client_id) || empty($this->kakao_secret)) {
            return [];
        }

        $tokenResponse = $this->http()->asForm()->post('https://kauth.kakao.com/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->kakao_client_id,
            'redierct_uri' => jt_route('auth.callback.kakao'),
            'client_secret' => $this->kakao_secret,
            'code' => $code,
        ]);

        $token = json_decode($tokenResponse->body(), true)['access_token'] ?? '';

        $response = $this->http()->withHeader('Authorization', 'Bearer ' . $token)->post(
            'https://kapi.kakao.com/v2/user/me',
        );

        $data = json_decode($response->body(), true);

        return [
            'kakao_id' => $data['id'],
            // 'name' => $data['kakao_account']['name'],
            'email' => $data['kakao_account']['email'],
            'mobile' => str_replace('+82 10', '010', $data['kakao_account']['phone_number']),
            // 'birth' => DateTime::createFromFormat('Ymd', $data['kakao_account']['birthyear'] . $data['kakao_account']['birthday'])->format('Y-m-d'),
        ];
    }

    public function getNaverLoginUrl()
    {
        if (empty($this->naver_client_id)) {
            return '';
        }

        return 'https://nid.naver.com/oauth2.0/authorize?' . http_build_query([
            'client_id' => $this->naver_client_id,
            'response_type' => 'code',
            'redirect_uri' => jt_route('auth.callback.naver'),
        ]);
    }

    public function getNaverData(string $code)
    {
        if (empty($this->naver_client_id) || empty($this->naver_secret)) {
            return [];
        }

        $tokenResponse = $this->http()->asForm()->post('https://nid.naver.com/oauth2.0/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->naver_client_id,
            'redierct_uri' => jt_route('auth.callback.naver'),
            'client_secret' => $this->naver_secret,
            'code' => $code,
        ]);

        $token = json_decode($tokenResponse->body(), true)['access_token'] ?? '';

        $response = $this->http()->withHeader('Authorization', 'Bearer ' . $token)->post(
            'https://openapi.naver.com/v1/nid/me',
        );

        $data = json_decode($response->body(), true);

        return [
            'naver_id' => $data['response']['id'],
            // 'name' => $data['response']['name'],
            'email' => $data['response']['email'],
            'mobile' => $data['response']['mobile'],
            // 'birth' => $data['response']['birthyear'] . '-' . $data['response']['birthday'],
        ];
    }

    public function getGoogleLoginUrl()
    {
        if (empty($this->google_client_id)) {
            return '';
        }

        return 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
            'client_id' => $this->google_client_id,
            'response_type' => 'code',
            'redirect_uri' => jt_route('auth.callback.google'),
            'scope' => 'openid email profile',
        ]);
    }

    public function getGoogleData(string $code)
    {
        if (empty($this->google_client_id) || empty($this->google_secret)) {
            return [];
        }

        $tokenResponse = $this->http()->asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->google_client_id,
            'client_secret' => $this->google_secret,
            'redirect_uri' => jt_route('auth.callback.google'),
            'code' => $code,
        ]);

        $token = json_decode($tokenResponse->body(), true)['access_token'] ?? '';

        $response = $this->http()->withHeader('Authorization', 'Bearer ' . $token)->get(
            'https://www.googleapis.com/oauth2/v2/userinfo'
        );

        $data = json_decode($response->body(), true);

        return [
            'google_id' => $data['id'],
            'email' => $data['email'],
            //'name' => $data['name'] ?? '',
        ];
    }
}
