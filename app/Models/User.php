<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'locale',

        'name',
        'email',
        'password',
        'mobile',
        'birth',
        'gender',
        'location',
        'source',
        'source_etc',
        'marketing',
        'marketing_updated_at',
        'last_logged_in',

        'kakao_id',
        'kakao_connected',
        'naver_id',
        'naver_connected',
        'google_id',
        'google_connected',

        'memo',
        'withdraw',
        'withdraw_memo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts() : array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth' => 'date',
            'gender' => 'boolean',
            'marketing' => 'boolean',
            'marketing_updated_at' => 'datetime',
            'last_logged_in' => 'datetime',
            'kakao_connected' => 'datetime',
            'naver_connected' => 'datetime',
            'google_connected' => 'datetime',
        ];
    }

    public function getSnsConnectionLabels() : string
    {
        $result = [];

        if ($this->kakao_id) {
            $result[] = '카카오';
        }

        if ($this->naver_id) {
            $result[] = '네이버';
        }

        if ($this->google_id) {
            $result[] = '구글';
        }

        return ! empty($result) ? implode(', ', $result) : '-';
    }

    public function isKorean()
    {
        return ! empty($this->mobile);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function can_withdraw()
    {
        return $this->reservations()->whereNotNull('paid_at')->whereNull('used_at')->whereNull('canceled_at')->count() === 0;
    }
}
