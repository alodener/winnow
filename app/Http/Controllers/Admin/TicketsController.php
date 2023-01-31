<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tickets = Ticket::orderBy('id', 'desc')->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::whereId($id)->first();
        $ticketResponses = TicketResponse::where('ticket_id', $ticket->id)->get();
        return view('admin.tickets.show', compact('ticket', 'ticketResponses'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $ticket_id = $request->ticket_id;
        $check = Ticket::whereId($ticket_id)->first();

        if($check == null) {
            Session::flash('status-warning', 'Alguma coisa deu errado. Por favor tente outra vez!');
            return redirect()->back();
        }

        $response = new TicketResponse();
        $response->user_id = $user->id;
        $response->ticket_id = $ticket_id;
        $response->messageBy = 'admin';
        $response->message = $request->message;
        $response->save();

        Ticket::whereId($ticket_id)->update(['status'=>1]);

        $notification = new Notification();
        $notification->user_id = $check->user_id;
        $notification->title = '#' . $ticket_id . ' Resposta do ticket recebido';
        $notification->description = 'Você recebe uma resposta no seu suporte de ticket com id: ' . $ticket_id . '.';
        $notification->save();

        Session::flash('status', 'Você respondeu com sucesso a este ticket!');

        return redirect()->back();

    }

    public function update(Request $request, $id)
     {

    }

    public function destroy($id)
    {

        $check = Ticket::whereId($id)->first();

        if($check == null) {
            Session::flash('status-warning', 'Alguma coisa deu errado. Por favor tente outra vez!');
            return redirect()->back();
        }

        $check->delete();

        Session::flash('status', 'Ticket removido com Sucesso!');
        return redirect()->back();
    }



}
