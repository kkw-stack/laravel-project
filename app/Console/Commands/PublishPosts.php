<?php

namespace App\Console\Commands;

use App\Models\Attraction;
use App\Models\Event;
use App\Models\Faq;
use App\Models\News;
use App\Models\Notice;
use App\Models\Privacy;
use App\Models\Service;
use Illuminate\Console\Command;

class PublishPosts extends Command
{
    protected $signature = 'jt:publish';
    protected $description = 'Publish Board Contents';

    public function handle()
    {
        Notice::where('status', false)->where('published_at', '<=', now())->update(['status' => true]); // 공지사항
        News::where('status', false)->where('published_at', '<=', now())->update(['status' => true]); // 뉴스
        Event::where('status', false)->where('published_at', '<=', now())->update(['status' => true]); // 이벤트
        Faq::where('status', false)->where('published_at', '<=', now())->update(['status' => true]); // FAQ
        Privacy::where('status', false)->where('published_at', '<=', now())->update(['status' => true]); // 개인정보 처리 방침
        Service::where('status', false)->where('published_at', '<=', now())->update(['status' => true]); // 이용약관
        Attraction::where('status', false)->where('published_at', '<=', now())->update(['status' => true]); // 주변볼거리
    }
}
