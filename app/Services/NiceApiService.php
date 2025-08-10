<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class NiceApiService extends Service
{
    public string $url = 'https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb';
    private ?string $client_id;
    private ?string $secret;
    private ?string $product_id;

    public function __construct()
    {
        $this->client_id = config('jt.nice_client_id');
        $this->secret = config('jt.nice_secret');
        $this->product_id = config('jt.nice_product_id');
    }

    public function decrypt($data)
    {
        $data = base64_decode($data);
        $data = openssl_decrypt($data, 'AES-128-CBC', session('nice_key'), OPENSSL_RAW_DATA, session('nice_iv'));
        $data = iconv('euc-kr', 'utf-8', $data);

        session()->forget(['nice_key', 'nice_iv']);

        return json_decode($data, true);
    }


    public function getFormData($callback)
    {
        $datetime = date('YmdHis');
        $reqno = uniqid();
        $token = $this->getAccessToken();
        $data = $this->encrypt($token, $datetime, $reqno);

        $symmetric_key = base64_encode(hash('sha256', $datetime . $reqno . $data['token_val'], true));
        $key = substr($symmetric_key, 0, 16);
        $iv = substr($symmetric_key, -16);
        $hmac_key = substr($symmetric_key, 0, 32);

        session([
            'nice_key' => $key,
            'nice_iv' => $iv,
        ]);

        $req_data = json_encode([
            'requestno' => $reqno,
            'returnurl' => jt_route('auth.callback.nice'),
            'sitecode' => $data['site_code'],
            'methodtype' => 'get',
            'authtype' => 'M',
            'popupyn' => 'Y',
            'receivedata' => http_build_query(['callback' => jt_route($callback)]),
        ]);

        $enc_data = base64_encode(openssl_encrypt($req_data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv));
        $integrity_value = base64_encode(hash_hmac('sha256', $enc_data, $hmac_key, true));

        return [
            'm' => 'service',
            'token_version_id' => $data['token_version_id'],
            'enc_data' => $enc_data,
            'integrity_value' => $integrity_value,
        ];
    }

    private function encrypt($token, $datetime, $reqno)
    {
        $response = $this->http()
            ->withHeaders([
                'Authorization' => 'Bearer ' . base64_encode($token . ':' . time() . ':' . $this->client_id),
                'client_id' => $this->client_id,
                'ProductID' => $this->product_id,
            ])->post(
                'https://svc.niceapi.co.kr:22001/digital/niceid/api/v1.0/common/crypto/token',
                [
                    'dataBody' => [
                        'req_dtim' => $datetime,
                        'req_no' => $reqno,
                        'enc_mode' => '1',
                    ],
                ]
            );

        return $this->getData($response);
    }

    private function getAccessToken()
    {
        $response = $this->http()
            ->asForm()
            ->withHeaders([
                'Authorization' => 'Basic ' . base64_encode($this->client_id . ':' . $this->secret),
            ])
            ->post('https://svc.niceapi.co.kr:22001/digital/niceid/oauth/oauth/token', [
                'scope' => 'default',
                'grant_type' => 'client_credentials',
            ]);

        return $this->getData($response, 'access_token');
    }

    private function getData(Response $response, $key = null)
    {
        if (! $response->successful()) {
            $response->throw();
        }

        $result = json_decode($response->body(), true);

        if (1200 !== intval($result['dataHeader']['GW_RSLT_CD'] ?? 0)) {
            throw new \Exception($result['dataHeader']['GW_RSLT_MSG'] ?? '', $result['dataHeader']['GW_RSLT_CD'] ?? 0);
        }

        if (! is_null($key)) {
            return $result['dataBody'][$key];
        }

        return $result['dataBody'];
    }
}
