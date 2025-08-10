<?php

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class EasypayService
{
    private string $api_url;
    private string $secret_key;
    private string $mall_id;

    public function __construct()
    {
        $is_dev = config('app.env', 'production') !== 'production';

        if (!$is_dev) {
            $this->api_url = 'https://testpgapi.easypay.co.kr';
            $this->secret_key = config('jt.easypay_test_secret_key', '');
            $this->mall_id = config('jt.easypay_test_mall_id', '');
        } else {
            $this->api_url = 'https://pgapi.easypay.co.kr';
            $this->secret_key = config('jt.easypay_secret_key', '');
            $this->mall_id = config('jt.easypay_mall_id', '');
        }
    }

    public function getAuthPageUrl(Reservation $reservation, string $payment, bool $is_mobile = false) : string|false
    {
        $response = $this->request('api/ep9/trades/webpay', [
            'mallId' => $this->mall_id,
            'payMethodTypeCode' => $payment,
            'currency' => '00',
            'amount' => $reservation->amount,
            'clientTypeCode' => '00',
            'returnUrl' => jt_route('reservation.payment.callback', compact('reservation')),
            'shopOrderNo' => $reservation->code,
            'deviceTypeCode' => $is_mobile ? 'mobile' : 'pc',
            'langFlag' => app()->getLocale() === 'en' ? 'ENG' : 'KOR',
            'orderInfo' => [
                'goodsName' => $reservation->ticket->title[app()->getLocale() === 'en' ? 'en' : 'ko'],
                'customerInfo' => [
                    'customerId' => $reservation->user_id > 0 ? 'member' : 'guest',
                    'customerName' => $reservation->user_name,
                    'customerMail' => $reservation->user_email,
                    'customerContactNo' => str_replace('-', '', $reservation->user_mobile),
                ],
            ],
        ]);

        /*
        [
            "resCd" => "0000"
            "resMsg" => "정상"
            "authPageUrl" => "https://testpgapi.easypay.co.kr/view/trades/cert-req.do?authorizationId=24081308560010790233"
        ]
         */
        return $response['authPageUrl'] ?? false;
    }

    public function approval(Reservation $reservation, string $authorization_id)
    {
        $response = $this->request('api/ep9/trades/approval', [
            'mallId' => $this->mall_id,
            'shopTransactionId' => uniqid(),
            'authorizationId' => $authorization_id,
            'shopOrderNo' => $reservation->code,
            'approvalReqDate' => date('Ymd'),
        ]);

        /*
        [
            "resCd" => "0000"
            "resMsg" => "MPI결제 정상"
            "mallId" => "T0020391"
            "pgCno" => "24081308560510790235"
            "shopTransactionId" => "66baa1377bb15"
            "shopOrderNo" => "20210326085908"
            "amount" => 51004
            "transactionDate" => "20240813085635"
            "statusCode" => "TS03"
            "statusMessage" => "매입요청"
            "msgAuthValue" => "8ea7f8f5ef8ab5c80f409d3dccafeca6c6cb89e5dfda2a41a5d3493e94a146ca"
            "escrowUsed" => "N"
            "paymentInfo" => [
                "payMethodTypeCode" => "11"
                "approvalNo" => "00190653"
                "approvalDate" => "20240813085635"
                "cardInfo" => [
                    "cardNo" => "41190400****704*"
                    "issuerCode" => "008"
                    "issuerName" => "OK:00190653"
                    "acquirerCode" => "008"
                    "acquirerName" => "Payzone TestCard"
                    "installmentMonth" => 0
                    "freeInstallmentTypeCode" => "00"
                    "cardGubun" => "N"
                    "cardBizGubun" => "P"
                    "partCancelUsed" => "Y"
                    "subCardCd" => ""
                    "cardMaskNo" => ""
                    "vanSno" => "000111000111"
                    "couponAmount" => 0
                ]
                "cpCode" => ""
                "multiCardAmount" => ""
                "multiPntAmount" => ""
                "multiCponAmount" => ""
                "bankInfo" => [
                    "bankCode" => ""
                    "bankName" => ""
                ]
                "virtualAccountInfo" => [
                    "bankCode" => ""
                    "bankName" => ""
                    "accountNo" => ""
                    "depositName" => ""
                    "expiryDate" => ""
                ]
                "mobInfo" => [
                    "authId" => ""
                    "billId" => ""
                    "mobileNo" => ""
                    "mobileAnsimUsed" => ""
                    "mobileCd" => ""
                ]
                "prepaidInfo" => [
                    "billId" => ""
                    "remainAmount" => 0
                ]
                "cashReceiptInfo" =>[
                    "resCd" => ""
                    "resMsg" => ""
                    "approvalNo" => ""
                    "approvalDate" => ""
                ]
                "basketInfoList" => []
            ]
        ]
        */

        return $response;
    }

    public function cancel(Reservation $reservation, int $revise_amount, string $ip) : array
    {
        $uniqid = uniqid();

        $data = [
            'mallId' => $this->mall_id, // KICC 에서 발급한 상점 ID
            'shopTransactionId' => $uniqid, // 가맹점 트랜잭션 ID
            'pgCno' => $reservation->paid_id, // KICC 거래번호
            'reviseTypeCode' => '40', // 변경구분
            // 'reviseSubTypeCode' => '', // 변경세부구분
            'amount' => $revise_amount, // 환불금액
            'remainAmount' => $reservation->amount, // 취소가능금액
            'reviseMessage' => '방문자 예약취소', // 변경사유
            'clientIp' => $ip, // 요청자 IP
            'clientId' => '메덩골정원 홈페이지', // 요청자 ID
            'msgAuthValue' => hash_hmac('sha256', $reservation->paid_id . '|' . $uniqid, $this->secret_key, false), // $reservation->payment->msg_auth_value, // 메시지 인증값
            'cancelReqDate' => Carbon::now()->format('Ymd'), // 취소 요청 일자 (Ymd)
        ];

        if ($reservation->amount > $revise_amount) {
            if ('21' == $reservation->paid_method) {
                $data['reviseTypeCode'] = '33';
            } else {
                $data['reviseTypeCode'] = '32';
            }
        }


        $response = $this->request('api/trades/revise', $data);

        /*
        [
            "resCd" => "0000"
            "resMsg" => "EDI 취소 매입처리로 취소처리됨"
            "mallId" => "T0020391"
            "shopTransactionId" => "66d65fc4f1841"
            "shopOrderNo" => "20240906-00004"
            "oriPgCno" => "24090309595910880703"
            "cancelPgCno" => "24090910510410920373"
            "transactionDate" => "20240909105104"
            "cancelAmount" => 123
            "remainAmount" => 0
            "statusCode" => "TS05"
            "statusMessage" => "매입취소"
            "escrowUsed" => "N"
            "reviseInfo" => [
                "payMethodTypeCode" => "11"
                "approvalNo" => ""
                "approvalDate" => "20240909105104"
                "cardInfo" => [
                    "couponAmount" => 0
                ]
                "refundInfo" => [
                    "refundDate" => ""
                    "depositPgCno" => ""
                ]
                "cashReceiptInfo" => [
                    "resCd" => ""
                    "resMsg" => ""
                    "approvalNo" => ""
                    "cancelDate" => ""
                ]
            ]
        */

        return $response;
    }

    private function request(string $url, mixed $data)
    {
        $response = Http::withoutVerifying()->post($this->api_url . '/' . trim($url, '/'), $data);

        return json_decode($response->body(), true);
    }
}
