<?php

namespace App\Services;
use App\Helpers\Formatter;
use App\Models\Reservation;
use Illuminate\Support\Carbon;

class AligoService extends Service
{
    public const SUCCESS = 'TZ_7043';
    public const CANCEL = 'TZ_5962';
    public const SCHEDULE = 'TY_8520';
    public const DAY_BEFORE = 'TZ_5468';

    private string $apikey;
    private string $userid;
    private string $senderkey;
    private string $sender;
    private bool $is_dev;

    public function __construct()
    {
        $this->apikey = config('jt.aligo_apikey', '');
        $this->userid = config('jt.aligo_userid', '');
        $this->senderkey = config('jt.aligo_senderkey', '');
        $this->sender = Formatter::phone(config('jt.aligo_sender', ''));
        $this->is_dev = config('app.env', 'production') !== 'production';
    }

    public function send_success(Reservation $reservation)
    {
        return $this->send($reservation, self::SUCCESS);
    }

    public function send_cancel(Reservation $reservation)
    {
        return $this->send($reservation, self::CANCEL);
    }

    public function send_schedule(Reservation $reservation)
    {
        return $this->send($reservation, self::SCHEDULE);
    }

    public function send_daybefore(Reservation $reservation)
    {
        return $this->send($reservation, self::DAY_BEFORE);
    }

    private function send(Reservation $reservation, string $template_code)
    {
        if ($this->should_send($reservation)) {
            $subject = '예약 완료 안내';
            $content = $this->get_content($template_code, $reservation);

            if (self::CANCEL === $template_code) {
                $subject = '예약 취소 안내';
            } elseif (self::SCHEDULE === $template_code) {
                $subject = '방문 전 안내';
            } elseif (self::DAY_BEFORE === $template_code) {
                $subject = '메덩골정원 방문 안내';
            }

            $data = [
                'apikey' => $this->apikey,
                'userid' => $this->userid,
                'senderkey' => $this->senderkey,
                'tpl_code' => $template_code,
                'sender' => $this->sender,
                'receiver_1' => Formatter::phone($reservation->user_mobile),
                'recvname_1' => $reservation->user_name,
                'subject_1' => $subject,
                'message_1' => $content,
            ];

            if (self::DAY_BEFORE === $template_code) {
                $data['button_1'] = json_encode([
                    'button' => [
                        [
                            'name' => '관람권 확인',
                            'linkType' => 'WL',
                            'linkP' => 'https://' . $this->get_qrcode_url($reservation),
                            'linkM' => 'https://' . $this->get_qrcode_url($reservation),
                        ]
                    ],
                ]);
            }

            if (! empty($content)) {
                return json_decode($this->http()->asForm()->post('https://kakaoapi.aligo.in/akv10/alimtalk/send/', $data)->body(), true);
            }
        }

        return false;
    }

    private function get_content(string $template_code, Reservation $reservation)
    {
        if (self::SUCCESS === $template_code) {
            return implode(PHP_EOL, [
                '[예약 완료 안내]',
                '발길마다 이야기가 흐르는 곳,',
                '메덩골정원의 방문 예약이 완료되었습니다.',
                '',
                '- 예약번호 : ' . $reservation->code,
                '- 관람권명 : ' . $reservation->ticket->title['ko'],
                '- 예약일자 : ' . date_format_korean($reservation->select_date, 'Y년 n월 j일(D)'),
                '- 방문시간 : ' . date_format_korean($reservation->select_time, 'A h:i') . ($reservation->use_docent ? '(정원 해설)' : ''),
                '- 방문인원 : ' . $reservation->get_visitors_label(),
                '- 결제수단 : ' . $reservation->get_payment_type(),
                '- 결제금액 : ' . number_format($reservation->amount) . ' 원',
                '',
                '▶ 관람권 안내',
                '관람일 하루 전, 모바일 티켓(QR코드)을 메시지로 보내 드립니다. 모바일 티켓은 메덩골정원 홈페이지 > 마이페이지에서도 확인하실 수 있습니다.',
                '',
                '▶ 할인 증빙서류 지참 안내',
                '- 성인 : 사진이 부착된 신분증(주민등록증, 운전면허증, 여권, 복지카드, 장애인등록증, 국가유공자증 등)',
                '- 미성년자 : 등본, 가족관계증명서 등',
                '- 외국인 : 여권 또는 신분 확인 가능 문서',
                '※ 증빙서류 미지참 시, 정상 가격분 추가 지불 후 입장 가능합니다.',
                '',
                '관람 문의: 031)771-1700 (대표번호)',
                ''
            ]);            
        } elseif (self::CANCEL === $template_code) {
            return implode(PHP_EOL, [
                '[예약 취소 안내]',
                '고객님의 메덩골정원 방문 예약이 정상적으로 취소되었습니다.',
                '예약 정보를 다시 한 번 확인해 주세요.',
                '',
                '- 예약번호 : ' . $reservation->code,
                '- 관람권명 : ' . $reservation->ticket->title['ko'],
                '- 예약일자 : ' . date_format_korean($reservation->select_date, 'Y년 n월 j일(D)'),
                '- 방문시간 : ' . date_format_korean($reservation->select_time, 'A h:i') . ($reservation->use_docent ? '(정원 해설)' : ''),
                '- 방문인원 : ' . $reservation->get_visitors_label(),
                '- 결제수단 : ' . $reservation->get_payment_type(),
                '- 결제금액 : ' . number_format($reservation->amount) . ' 원',
                '- 환불금액 : ' . number_format($reservation->canceled_amount) . ' 원',
                '',
                '※ 카드 승인 취소는 영업일 기준 최대 5~6일 소요될 수 있으며, 지연 시 해당 카드사로 문의해 주세요.',
                '',
                '문의: 031)771-1700 (대표번호)',
                '',
                '메덩골정원의 이야기는 언제든 열려 있습니다.',
                '고객님의 다음 방문을 기다리겠습니다.',
                ''
            ]);            
        } elseif (self::SCHEDULE === $template_code) {
            return implode(PHP_EOL, [
                '[방문 전 안내]',
                '대한민국 정원 역사 100여 년 만의 새로운 도전의 결실, 메덩골 한국정원 방문이 D-' . intval(Carbon::today()->diffInDays($reservation->select_date)) . '일 앞으로 다가왔습니다.',
                '',
                '쾌적한 관람을 위해 아래 유의사항을 꼭 확인해 주세요.',
                '',
                '[방문 시 유의사항]',
                '▶ 할인 증빙서류 지참 필수',
                '- 성인 : 사진이 부착된 신분증(주민등록증, 운전면허증, 여권, 복지카드, 장애인등록증, 국가유공자증 등)',
                '- 미성년자 : 등본, 가족관계증명서 등',
                '- 외국인 : 여권 또는 신분 확인 가능 문서',
                '※ 증빙서류 미지참 시, 정상 가격분 추가 지불 후 입장 가능합니다.',
                '',
                '▶ 반입 금지 품목',
                '성냥, 라이터 등 발화물질, 유아용 웨건, 장난감, 돗자리, 텐트, 그늘막, 채집 도구, 삼각대, 공, 킥보드, 드론 등 다른 관람객에게 불편을 끼칠 수 있는 물품의 반입은 제한됩니다.',
                '',
                '▶ 취식 및 흡연 금지',
                '- 외부 음식물 반입 및 취식은 불가합니다. (※ 이유식 등 유아 식음료는 가능)',
                '- 주차장을 포함한 모든 구역에서 흡연이 불가합니다.',
                '',
                '▶ 반려동물 입장 제한',
                '장소 특성상 반려동물 동반 입장은 제한됩니다. (※ 시각 안내견 등 보조견은 동반 가능)',
                '',
                '※ 현재 비지터센터와 일부 공간은 더욱 높은 완성도를 위해 준비 중입니다. 관람 시 일부 구역의 이용이 제한될 수 있는 점, 양해 부탁드립니다.',
                '',
                '관람 문의: 031)771-1700 (대표번호)',
                ''
            ]);            
        } elseif (self::DAY_BEFORE === $template_code) {
            return implode(PHP_EOL, [
                '[메덩골정원 방문 안내]',
                '내일, 아름다운 자연 속에서 준비된 이야기가 여러분을 기다립니다.',
                '방문 전 예약 정보를 다시 한 번 확인해 주세요.',
                '',
                '- 예약번호 : ' . $reservation->code,
                '- 관람권명 : ' . $reservation->ticket->title['ko'],
                '- 예약일자 : ' . date_format_korean($reservation->select_date, 'Y년 n월 j일(D)'),
                '- 방문시간 : ' . date_format_korean($reservation->select_time, 'A h:i') . ($reservation->use_docent ? '(정원 해설)' : ''),
                '- 방문인원 : ' . $reservation->get_visitors_label(),
                '- 결제금액 : ' . number_format($reservation->amount) . ' 원',
                '',
                '[모바일 티켓 확인 & 입장 방법]',
                '▶ 모바일 티켓 확인: 아래의 관람권 확인 버튼 클릭',
                '▶ 홈페이지 > 마이페이지 > [사용하기] 버튼 클릭 시에도 확인 가능합니다.',
                '입장 시, 모바일 티켓(QR 코드)을 직원에게 제시해 주세요.',
                '',
                '[관람 유의사항 간단 안내]',
                '- 할인 증빙서류 필참',
                '- 외부 음식물, 발화물질 등 반입 제한',
                '- 반려동물 동반 입장 제한',
                '- 주차장을 포함한 전구역 흡연 금지',
                '',
                '※ 현재 비지터센터와 일부 공간은 더욱 높은 완성도를 위해 준비 중입니다. 관람 시 일부 구역의 이용이 제한될 수 있는 점, 양해 부탁드립니다.',
                '',
                '관람 문의: 031)771-1700 (대표번호)',
                '',
                '내일, 메덩골정원에서 뵙겠습니다.',
                ''
            ]);
        }

        return null;
    }

    private function should_send(Reservation $reservation)
    {
        return ! empty($this->apikey) && ! empty($this->userid) && ! empty($this->senderkey) && ! empty($this->sender) && ! empty($reservation->user_mobile);
    }

    private function get_qrcode_url(Reservation $reservation)
    {
        $url = jt_route('member.reservation.qrcode', compact('reservation'));
        $url = preg_replace('/^https?:\/\//', '', $url);

        return $url;
    }
}
