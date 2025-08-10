<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PopupRequest;
use App\Models\Popup;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('main/popup')]
class PopupController extends Controller
{
    #[Get('', 'admin.main.popup.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $popups = Popup::where('locale', $locale)->latest()->paginate(10);
        $sortPopups = Popup::where('locale', $locale)->where('status', true)->orderBy('order_idx')->latest()->get();

        return view('admin.main.popup.list', compact('locale', 'popups', 'sortPopups'));
    }

    #[Post('', 'admin.main.popup.store.order')]
    public function store_order(Request $request)
    {
        if (! empty($request->sort_ids)) {
            foreach ($request->sort_ids as $idx => $popup_id) {
                Popup::where('id', $popup_id)->update(['order_idx' => $idx]);
            }
        }

        return to_route('admin.main.popup.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-06'));
    }

    #[Get('create', 'admin.main.popup.create')]
    #[Get('{popup}', 'admin.main.popup.detail')]
    public function detail(Request $request, ?Popup $popup = null)
    {
        return view('admin.main.popup.detail', compact('popup'));
    }

    #[Post('create', 'admin.main.popup.store')]
    #[Post('{popup}', 'admin.main.popup.update')]
    public function store(PopupRequest $request, ?Popup $popup = null)
    {
        $request->handle($popup);

        if (is_null($popup)) {
            return to_route('admin.main.popup.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.main.popup.detail', array_merge($request->query(), compact('popup'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{popup}', 'admin.main.popup.delete')]
    public function delete(Request $request, Popup $popup)
    {
        $popup->delete();

        return to_route('admin.main.popup.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }
}
