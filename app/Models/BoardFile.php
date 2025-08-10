<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'file_mime',
        'file_name',
        'file_size',
        'file_path',
    ];

    protected $casts = [
        'file_size' => 'int',
    ];

    public function board()
    {
        return $this->morphTo();
    }
}
