<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleCategory extends Model
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

    public function people()
    {
        return $this->hasMany(People::class, 'category_id');
    }
}
