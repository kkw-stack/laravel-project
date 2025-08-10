<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'user_name',
        'user_email',
        'user_mobile',
        'user_birth',
        'user_gender',
        'locale',
        'code',
        'select_date',
        'select_time',
        'use_docent',
        'visitors',
        'total_visitors',
        'amount',
        'memo',
        'used_at',
        'canceled_at',
        'canceled_amount',
        'canceled_by',
        'paid_id',
        'paid_method',
        'paid_at',
    ];
    protected $casts = [
        'ticket_id' => 'integer',
        'user_id' => 'integer',
        'user_birth' => 'date',
        'select_date' => 'datetime:Y-m-d',
        'select_time' => 'datetime:H:i:s',
        'use_docent' => 'integer',
        'visitors' => 'array',
        'total_visitors' => 'integer',
        'amount' => 'integer',
        'used_at' => 'datetime',
        'canceled_at' => 'datetime',
        'canceled_amount' => 'integer',
        'canceled_by' => 'integer',
        'paid_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function withdraw_user()
    {
        return $this->belongsTo(WithdrawUser::class, 'user_id')->withTrashed();
    }

    public function canceled_by()
    {
        return $this->belongsTo(Manager::class, 'canceled_by');
    }

    public function is_own()
    {
        if (Auth::guard('web')->check() && request()->user('web')->id === $this->user_id) {
            return true;
        }

        $nice_data = request()->session()->get('nice_data');
        if (str_replace('-', '', $nice_data['mobile'] ?? '') === $this->user_mobile) {
            return true;
        }

        return false;
    }

    public function get_visitors_label()
    {
        $locale = app()->getLocale();
        $result = [];
        foreach ($this->visitors as $key => $count) {
            if (array_key_exists($key, Ticket::PRICE_LABELS)) {
                $result[] = __('front.reservation.common.visitor', ['LABEL' => Ticket::PRICE_LABELS[$key], 'COUNT' => $count]);
            } elseif (array_key_exists($key, Ticket::PRICE_FOREIGN_LABELS)) {
                $result[] = __('front.reservation.common.visitor', ['LABEL' => Ticket::PRICE_FOREIGN_LABELS[$key], 'COUNT' => $count]);
            }
        }

        return implode(', ', $result);
    }

    public function can_cancel() : bool
    {
        return is_null($this->canceled_at) && is_null($this->used_at) && intval(Carbon::today()->diffInDays($this->select_date)) > 1;
    }

    public function can_use() : bool
    {
        return is_null($this->canceled_at) && is_null($this->used_at) && ! is_null($this->paid_at) && intval(Carbon::today()->diffInDays($this->select_date)) === 0;
    }

    public function is_past() : bool
    {
        return is_null($this->canceled_at) && intval(Carbon::today()->diffInDays($this->select_date)) < 0;
    }

    public function is_future() : bool
    {
        return is_null($this->canceled_at) && Carbon::today()->diffInDays($this->select_date) > 0;
    }

    public function get_cancel_message() : string
    {
        $diff = (int) Carbon::today()->diffInDays($this->select_date);
        $message = '';

        if ($diff >= 3 || $this->amount === 0) {
            $message = __('jt.CA-01');
        } elseif ($diff === 2) {
            $message = __('jt.CA-03');
        } elseif ($diff <= 1) {
            $message = __('jt.CA-04');
        }

        return $message;
    }

    public function get_payment_type()
    {
        if ('21' === $this->paid_method) {
            return __('front.reservation.result.payment-type.bank');
        } elseif ('22' === $this->paid_method) {
            return __('front.reservation.result.payment-type.etc'); // '가상계좌';
        } elseif ('00' === $this->paid_method) {
            return __('front.reservation.result.payment-type.etc');
        }

        return __('front.reservation.result.payment-type.credit');
    }

    public function get_paid_status()
    {
        if (! is_null($this->canceled_at)) {
            return '취소';
        } elseif (! is_null($this->paid_at)) {
            return '결제완료';
        }

        return '결제대기';
    }

    public function get_used_status()
    {
        if (! is_null($this->used_at)) {
            return '사용완료';
        } elseif (is_null($this->used_at) && intval(Carbon::today()->diffInDays($this->select_date)) < 0) {
            return '기간만료';
        }

        return '사용전';
    }

    public function get_select_datetime()
    {
        return new Carbon($this->select_date->format('Y-m-d') . ' ' . $this->select_time->format('H:i:00'));
    }

    public function select_date_diff_in_minutes(Carbon $compare = null, bool $absolute = true)
    {
        $compare = $compare ?? Carbon::now();

        return $this->get_select_datetime()->diffInMinutes($compare, $absolute);
    }
}
