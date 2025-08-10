<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\News;
use App\Models\Notice;
use App\Models\People;
use App\Models\Privacy;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerate extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap.';
    protected Sitemap $sitemap;
    protected Carbon $staticUpdated;
    protected bool $isDev = false;


    public function __construct()
    {
        parent::__construct();

        $this->staticUpdated = Carbon::create('2024-06-18');
        $this->sitemap = Sitemap::create();
        $this->isDev = config('app.env', 'production') === 'development';

    }

    public function handle()
    {
        $locales = ['ko', 'en'];

        foreach ($locales as $locale) {

            // HOME
            $this->addStaticSiteMap($locale . '.index');

            // 소개
            $this->addStaticSiteMap($locale . '.introduce.about');
            $this->addStaticSiteMap($locale . '.introduce.people');
            $this->addStaticSiteMap($locale . '.introduce.history');
            $this->addStaticSiteMap($locale . '.introduce.sustainability');

            $this->sitemap->add(People::where('status', true)->where('locale', $locale)->where('published_at', '<=', Carbon::now())->orderByDesc('published_at')->latest()->get());

            // 정원
            $this->addStaticSiteMap($locale . '.garden.korea');

            // 건축물
            $this->addStaticSiteMap($locale . '.construct.visitor-center');
            $this->addStaticSiteMap($locale . '.construct.pezo-restaurant');
            $this->addStaticSiteMap($locale . '.construct.seongok-seowon');

            // 새소식
            $this->addModelListSiteMap($locale . '.board.notice.list', Notice::class);
            $this->sitemap->add(Notice::where('status', true)->where('locale', $locale)->where('published_at', '<=', now())->orderByDesc('published_at')->latest()->get());
            $this->addModelListSiteMap($locale . '.board.news.list', News::class);
            $this->sitemap->add(News::where('status', true)->where('locale', $locale)->where('published_at', '<=', now())->orderByDesc('published_at')->latest()->get());
            // $this->addModelListSiteMap($locale . '.board.event.list', Event::class);
            // $this->sitemap->add(Event::where('status', true)->where('published_at', '<=', now())->orderByDesc('published_at')->latest()->get());

            // 이용안내
            if ($this->isDev) {
                $this->addStaticSiteMap($locale . '.manual.visitor-guide');
                $this->addStaticSiteMap($locale . '.manual.food-and-beverage');
                // $this->addStaticSiteMap($locale . '.manual.venue-rentals');
                // $this->addStaticSiteMap($locale . '.manual.wedding');
                $this->addStaticSiteMap($locale . '.manual.faq');
                $this->addStaticSiteMap($locale . '.manual.location');
                $this->addStaticSiteMap($locale . '.manual.local-attractions');
            }

            // 약관
            if ($this->isDev) {
                $this->addModelListSiteMap($locale . '.policy.privacy', Privacy::class);
                $this->addModelListSiteMap($locale . '.policy.terms', Service::class);
            }
        }

        $this->sitemap->writeToDisk('public', 'sitemap.xml', true);
    }

    private function addStaticSiteMap(string $route, float $priority = 0.5)
    {
        $this->sitemap->add(
            Url::create(route($route))
                ->setLastModificationDate($this->staticUpdated)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_NEVER)
                ->setPriority($priority)
        );
    }

    private function addModelListSiteMap(string $route, string $model, float $priority = 0.5)
    {
        $this->sitemap->add(
            Url::create(route($route))
                ->setLastModificationDate(
                    Carbon::create(
                        $model::where('status', true)
                            ->where('published_at', '<=', now())
                            ->orderByDesc('published_at')
                            ->latest()
                            ->first()
                                ?->updated_at ?? $this->staticUpdated
                    )
                )
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority($priority)
        );
    }
}
