<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketConfigRequest;
use App\Http\Requests\Admin\TicketRequest;
use App\Models\Ticket;
use App\Models\TicketConfig;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('ticket')]
class TicketController extends Controller
{
    #[Get('config', 'admin.ticket.config')]
    public function config(Request $request) : View
    {
        $config = TicketConfig::latest()->first();

        return view('admin.ticket.config', compact('config'));
    }

    #[Post('config', 'admin.ticket.config.store')]
    public function store_config(TicketConfigRequest $request) : RedirectResponse
    {
        $request->handle();

        return to_route('admin.ticket.config')->with('success-message', __('jt.ME-02'));
    }

    #[Get('', 'admin.ticket.list')]
    public function list(Request $request) : View
    {
        $tickets = Ticket::orderBy('order_idx')->latest()->get();

        return view('admin.ticket.list', compact('tickets'));
    }

    #[Post('', 'admin.ticket.store.order')]
    public function store_order(Request $request) : RedirectResponse
    {
        foreach ($request->ticket_ids as $idx => $ticket_id) {
            Ticket::where('id', $ticket_id)->update(['order_idx' => $idx]);
        }

        return to_route('admin.ticket.list')->with('success-message', __('jt.ME-06'));
    }

    #[Get('create', 'admin.ticket.create')]
    #[Get('{ticket}', 'admin.ticket.detail')]
    public function detail(Request $request, ?Ticket $ticket = null) : View
    {
        return view('admin.ticket.detail', compact('ticket'));
    }

    #[Post('create', 'admin.ticket.store')]
    #[Post('{ticket}', 'admin.ticket.update')]
    public function store(TicketRequest $request, ?Ticket $ticket = null) : RedirectResponse
    {
        $request->handle($ticket);

        if (is_null($ticket)) {
            return to_route('admin.ticket.list')->with('success-message', __('jt.ME-01'));
        }

        return to_route('admin.ticket.detail', compact('ticket'))->with('success-message', __('jt.ME-02'));
    }

    #[Delete('{ticket}', 'admin.ticket.delete')]
    public function delete(Request $request, Ticket $ticket) : RedirectResponse
    {
        if ($ticket->reservations->count() > 0) {
            return to_route('admin.ticket.detail', compact('ticket'))->with('error-message', __('jt.AL-11'));
        }

        $ticket->delete();

        return to_route('admin.ticket.list')->with('success-message', __('jt.ME-03'));
    }
}
