<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KoreaGardenCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'locale',
        'title',
        'content',
        'order_idx',
    ];
    protected $casts = [
        'order_idx' => 'integer',
    ];


    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function koreaGardens()
    {
        return $this->hasMany(KoreaGarden::class, 'category_id');
    }
}
