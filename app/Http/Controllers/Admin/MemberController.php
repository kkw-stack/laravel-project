<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\WithTrashed;

#[Prefix('member')]
class MemberController extends Controller
{
    #[Get('', 'admin.member.list')]
    public function list(Request $request) : View
    {
        $start_date = null;
        $end_date = null;
        $search_dates = array_filter($request->only('start_date', 'end_date'));
        if (is_array($search_dates) && 2 === count($search_dates)) {
            $start_date = min($search_dates);
            $end_date = max($search_dates);
        }

        return view('admin.member.list', [
            'rpp' => $request->query('rpp', 10),
            'search' => $request->query('search'),
            'search_type' => $request->query('search_type', 'name'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'user_type' => $request->query('user_type', 'all'),
            'users' => $this->get_search_query($request, $request->query('user_type', 'all'))->latest()->paginate($request->query('rpp', 10)),
            'total' => $this->get_search_query($request)->count(),
            'total_ko' => $this->get_search_query($request, 'ko')->count(),
            'total_en' => $this->get_search_query($request, 'en')->count(),
        ]);
    }

    #[Post('', 'admin.member.excel')]
    public function excel(Request $request)
    {
        return response(
            view('admin.member.excel', [
                'users' => $this->get_search_query($request, $request->query('user_type', 'all'))->latest()->get(),
            ]),
            200,
            [
                'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="medonguale_users_' . date('YmdHis') . '.xls"',
                'Content-Transfer-Encoding' => 'binary',
                'Pragma' => 'no-cache',
                'Expires' => 0,
            ]
        );
    }

    #[Get('{user}', 'admin.member.detail')]
    #[WithTrashed()]
    public function detail(Request $request, User $user) : View
    {
        return view('admin.member.detail', compact('user'));
    }

    #[Post('{user}', 'admin.member.store')]
    #[WithTrashed()]
    public function store(Request $request, User $user) : RedirectResponse
    {
        if ($request->exists('memo')) {
            $user->update($request->only('memo'));

            $request->session()->flash('success-message', __('jt.ME-02'));
        }

        return to_route('admin.member.detail', array_merge($request->query(), compact('user')));
    }

    #[Delete('{user}', 'admin.member.delete')]
    #[WithTrashed()]
    public function delete(Request $request, User $user)
    {
        if ($user->trashed()) {
            $user->restore();

            $request->session()->flash('success-message', __('jt.ME-05'));
        } else {
            $user->update([
                'withdraw' => '관리자 탈퇴 처리',
            ]);

            $user->delete();

            $request->session()->flash('success-message', __('jt.ME-04'));
        }

        return to_route('admin.member.detail', array_merge($request->query(), compact('user')));
    }

    #[Delete('{user}/force', 'admin.member.delete.force')]
    #[WithTrashed()]
    public function delete_force(Request $request, User $user)
    {
        $withdraw_user = $user->replicate();

        $withdraw_user->id = $user->id;
        $withdraw_user->setTable('withdraw_users');
        $withdraw_user->save();

        $user->forceDelete();

        return to_route('admin.member.list');
    }

    private function get_search_query(Request $request, string $user_type = 'all') : Builder
    {
        $search = $request->query('search');
        $search_type = $request->query('search_type', 'name');
        $start_date = null;
        $end_date = null;
        $search_dates = array_filter($request->only('start_date', 'end_date'));
        if (is_array($search_dates) && 2 === count($search_dates)) {
            $start_date = min($search_dates);
            $end_date = max($search_dates);
        }

        $query = User::withTrashed();

        if (! empty($start_date)) {
            $query->where('created_at', '>=', $start_date . ' 00:00:00');
        }

        if (! empty($end_date)) {
            $query->where('created_at', '<=', $end_date . ' 23:59:59');
        }

        if (! empty($search)) {
            $query->where(in_array($search_type, ['name', 'email', 'mobile']) ? $search_type : 'name', 'LIKE', '%' . str_replace(' ', '%', $search) . '%');
        }

        if ('ko' === $user_type) {
            $query->where('mobile', '<>', null);
        } elseif ('en' === $user_type) {
            $query->where('mobile', '=', null);
        }

        return $query;
    }
}
