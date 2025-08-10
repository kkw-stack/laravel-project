<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'locale',
        'title',
        'content',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function histories()
    {
        return $this->hasMany(History::class, 'category_id');
    }

    public function historyList()
    {
        return $this->hasMany(History::class, 'category_id')->where('status', true)->where('published_at', '<=', now())->orderBy('published_at')->oldest()->get();
    }
}
