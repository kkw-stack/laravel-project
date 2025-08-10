<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $guarded = [];

    public static function findByTokenAndValidate($token)
    {
        $record = self::get()->first(fn($record) => Hash::check($token, $record->token));
    
        if (! $record || $record->created_at < now()->subMinutes(config('auth.passwords.users.expire'))) {
            return null;
        }
    
        return $record;
    }
}
