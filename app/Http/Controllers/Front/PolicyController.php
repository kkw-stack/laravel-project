<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Privacy;
use App\Models\Service;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class PolicyController extends Controller
{
    public function __construct()
    {
        if (! $this->is_dev()) {
            abort(404);
        }
    }

    #[Get('privacy-policy', 'ko.policy.privacy')]
    #[Get('en/privacy-policy', 'en.policy.privacy')]
    public function privacy_policy(Request $request)
    {
        $locale = $this->get_locale();
        $privacy_id = intval($request->query('term'));

        $query = Privacy::query()
            ->where('locale', $locale)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->latest();

        $privacies = $query->get(['id', 'title']);

        if ($privacy_id > 0 && Privacy::where('id', $privacy_id)->where('locale', $locale)->where('status', true)->where('published_at', '<=', now())->exists()) {
            $privacy = Privacy::find($privacy_id);
        } else {
            $privacy = $query->first();
        }

        return view('front.policy.privacy', compact('privacies', 'privacy'));
    }

    #[Get('terms-of-service', 'ko.policy.terms')]
    #[Get('en/terms-of-service', 'en.policy.terms')]
    public function terms_of_service(Request $request)
    {
        $locale = $this->get_locale();
        $service_id = intval($request->query('term'));

        $query = Service::query()
            ->where('locale', $locale)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->latest();

        $services = $query->get(['id', 'title']);

        if ($service_id > 0 && Service::where('id', $service_id)->where('locale', $locale)->where('status', true)->where('published_at', '<=', now())->exists()) {
            $service = Service::find($service_id);
        } else {
            $service = $query->first();
        }

        return view('front.policy.terms', compact('services', 'service'));
    }
}
