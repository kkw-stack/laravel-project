<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManagerRequest;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Patch;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('manager')]
class ManagerController extends Controller
{
    #[Get('', 'admin.manager.list')]
    public function list(Request $request)
    {
        $search = $request->query('search');
        $query = Manager::withTrashed();

        if (true !== $request->user('admin')?->is_super) {
            $query->where('is_super', false);
        }

        if ($search) {
            $query->where(DB::raw('LOWER(name)'), 'like', '%' . str_replace(' ', '%', $search) . '%');
        }

        $query->latest();

        $managers = $query->paginate(10);

        return view('admin.manager.list', compact('search', 'managers'));
    }

    #[Get('create', 'admin.manager.create')]
    #[Get('{manager}', 'admin.manager.detail')]
    public function detail(Request $request, ?Manager $manager = null)
    {
        return view($manager?->trashed() ? 'admin.manager.restore' : 'admin.manager.detail', compact('manager'));
    }

    #[Post('create', 'admin.manager.store')]
    #[Post('{manager}', 'admin.manager.update')]
    public function store(ManagerRequest $request, ?Manager $manager = null)
    {
        $request->handle($manager);

        if (is_null($manager)) {
            return to_route('admin.manager.list')->with('success-message', __('jt.ME-01'));
        } else {
            return to_route('admin.manager.detail', array_merge($request->query(), compact('manager')))->with('success-message', __('jt.ME-02'));
        }
    }

    #[Delete('{manager}', 'admin.manager.delete')]
    public function delete(Request $request, Manager $manager)
    {
        $manager->delete();

        return to_route('admin.manager.list', $request->query())->with('success-message', __('jt.ME-04'));
    }

    #[Patch('{manager}', 'admin.manager.restore')]
    public function restore(Request $request, Manager $manager)
    {
        $manager->restore();

        return to_route('admin.manager.detail', [...$request->query(), ...compact('manager')])->with('success-message', __('jt.ME-05'));
    }
}
