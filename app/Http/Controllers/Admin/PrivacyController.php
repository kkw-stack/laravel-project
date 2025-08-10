<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PrivacyRequest;
use App\Models\Privacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('privacy')]
class PrivacyController extends Controller
{
    #[Get('', 'admin.privacy.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $searchType = $request->query('search_type', 'title');
        $search = $request->query('search');
        $query = Privacy::query()->where('locale', $locale);

        if (! empty($search)) {
            if ($searchType === 'author') {
                $query->whereHas('author', function ($query) use ($search) {
                    $query->where(DB::raw('LOWER(name)'), 'like', '%' . str_replace(' ', '%', $search) . '%');
                });
            } elseif (in_array($searchType, ['title', 'content'])) {
                $query->where($searchType, 'like', '%' . str_replace(' ', '%', $search) . '%');
            }
        }

        $query->orderByDesc('published_at');
        $query->latest();

        $privacies = $query->paginate(10);
        return view('admin.privacy.list', compact('locale', 'search', 'searchType', 'privacies'));
    }

    #[Get('create', 'admin.privacy.create')]
    #[Get('{privacy}', 'admin.privacy.detail')]
    public function detail(Request $request, ?Privacy $privacy = null)
    {
        return view('admin.privacy.detail', compact('privacy'));
    }

    #[Post('create', 'admin.privacy.store')]
    #[Post('{privacy}', 'admin.privacy.update')]
    public function store(PrivacyRequest $request, ?Privacy $privacy = null)
    {
        $request->handle($privacy);

        if (is_null($privacy)) {
            return to_route('admin.privacy.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.privacy.detail', array_merge($request->query(), compact('privacy'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{privacy}', 'admin.privacy.delete')]
    public function delete(Request $request, Privacy $privacy)
    {
        $privacy->delete();

        return to_route('admin.privacy.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }
}
