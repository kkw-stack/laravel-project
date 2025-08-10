<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('service')]
class ServiceController extends Controller
{
    #[Get('', 'admin.service.list')]
    public function list(Request $request)
    {
        $locale = $this->get_admin_locale();
        $searchType = $request->query('search_type', 'title');
        $search = $request->query('search');
        $query = Service::query()->where('locale', $locale);

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

        $services = $query->paginate(10);
        return view('admin.service.list', compact('locale', 'search', 'searchType', 'services'));
    }

    #[Get('create', 'admin.service.create')]
    #[Get('{service}', 'admin.service.detail')]
    public function detail(Request $request, ?Service $service = null)
    {
        return view('admin.service.detail', compact('service'));
    }

    #[Post('create', 'admin.service.store')]
    #[Post('{service}', 'admin.service.update')]
    public function store(ServiceRequest $request, ?Service $service = null)
    {
        $request->handle($service);

        if (is_null($service)) {
            return to_route('admin.service.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.service.detail', array_merge($request->query(), compact('service'), $this->get_admin_locale_params()))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{service}', 'admin.service.delete')]
    public function delete(Request $request, Service $service)
    {
        $service->delete();

        return to_route('admin.service.list', $this->get_admin_locale_params())->with('success-message', __('jt.ME-03'));
    }
}
