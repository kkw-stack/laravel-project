<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'locale',
        'question',
        'answer',
        'faq_category_id',
        'status',
        'published_at',
    ];
    protected $casts = [
        'faq_category_id' => 'integer',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];


    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }
}
