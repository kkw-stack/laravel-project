<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SceneryGalleryCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'board_scenery_categories';

    protected $fillable = [
        'locale',
        'name',
        'description',
    ];

    public function author()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function sceneries()
    {
        return $this->hasMany(SceneryGallery::class, 'scenery_category_id');
    }
}
