<?php

namespace App\Models;

use App\Helpers\Formatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Manager extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_super',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'is_super',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_super' => 'boolean',
    ];

    public function setPhoneAttribute(string $value)
    {
        if (false === Formatter::isPhone($value)) {
            throw new \InvalidArgumentException('유효한 핸드폰 번호가 아닙니다.');
        }

        $this->attributes['phone'] = Formatter::phone($value);
    }

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function sceneryCategories()
    {
        return $this->hasMany(SceneryGalleryCategory::class);
    }

    public function sceneries()
    {
        return $this->hasMany(SceneryGallery::class);
    }

    public function faqCategories()
    {
        return $this->hasMany(FaqCategory::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function privacies()
    {
        return $this->hasMany(Privacy::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function mainFeeds()
    {
        return $this->hasMany(MainFeed::class);
    }

    public function mainSceneries()
    {
        return $this->hasMany(MainScenery::class);
    }

    public function mainVisuals()
    {
        return $this->hasMany(MainVisual::class);
    }

    public function attractions()
    {
        return $this->hasMany(Attraction::class);
    }

    public function peopleCategories()
    {
        return $this->hasMany(PeopleCategory::class);
    }

    public function people()
    {
        return $this->hasMany(People::class);
    }

    public function koreaGardenCategories()
    {
        return $this->hasMany(KoreaGardenCategory::class);
    }

    public function koreaGardens()
    {
        return $this->hasMany(KoreaGarden::class);
    }

    public function koreaGardenFeeds()
    {
        return $this->hasMany(KoreaGardenFeed::class);
    }

    public function popups()
    {
        return $this->hasMany(Popup::class);
    }

    public function visitorGuides()
    {
        return $this->hasMany(VisitorGuide::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function historyCategories()
    {
        return $this->hasMany(HistoryCategory::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
