<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LogoutRequest;
use App\Http\Requests\Admin\ProfileRequest;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Any;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class ProfileController extends Controller
{
    #[Get('profile', 'admin.profile')]
    public function profile(Request $request)
    {
        return view('admin.manager.detail', ['manager' => $request->user('admin')]);
    }

    #[Post('profile', 'admin.profile.store')]
    public function storeProfile(ProfileRequest $request)
    {
        $request->handle($request->user('admin'));

        return to_route('admin.profile')->with('success-message', __('jt.ME-02'));
    }

    #[Any('logout', 'admin.auth.logout')]
    public function logout(LogoutRequest $request)
    {
        $request->handle();

        return to_route('admin.auth.login');
    }
}
