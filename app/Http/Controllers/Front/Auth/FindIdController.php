<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\NiceApiService;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;

#[Middleware(['guest'])]
class FindIdController extends Controller
{
    public function __construct(
        private NiceApiService $nice_service,
    ) {
        if (! $this->is_dev()) {
            abort(404);
        }
    }

    #[Get('auth/find-id', 'ko.auth.find-id')]
    #[Get('en/auth/find-id', 'en.auth.find-id')]
    public function find_id(Request $request)
    {
        if ($request->session()->has('nice_data')) {
            $nice_data = $request->session()->pull('nice_data');
            $user = User::where('mobile', $nice_data['mobile'])->first();

            if ($user) {
                $request->session()->flash('nice_data', $nice_data);

                return view('front.auth.find-id.success', compact('user'));
            }

            $request->session()->remove('nice_data');

            return view('front.auth.find-id.error');
        }

        return view('front.auth.find-id.cert', [
            'nice_url' => $this->nice_service->url,
            'nice_data' => $this->nice_service->getFormData('auth.find-id'),
        ]);
    }
}
