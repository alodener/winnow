<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tickets = Ticket::orderBy('id','desc')->where('user_id', auth()->user()->id)->paginate(10);
        return view('dashboard.tickets.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $ticket = new Ticket();
        $ticket->user_id = $user->id;
        $ticket->subject = $data['subject'];
        $ticket->message = $data['message'];
        $ticket->status  = 0;
        if($ticket->save()) {
//            $activity = new Activity();
//            $activity->user_id = $user->id;
//            $activity->type = 'account';
//            $activity->description = 'Created a support ticket!';
//            $activity->save();
            Session::flash('status','Your Ticket Was Created Successfully!');
            return redirect()->back();
        } else {
            Session::flash('status-warning','Something went wrong. please try again!');
            return redirect()->back();
        }
    }

    public function storeResponse(Request $request)
    {
        $user = Auth::user();
        $ticket_id = $request->ticket_id;
        $check = Ticket::whereId($ticket_id)->where('user_id', $user->id)->first();
        if($check == null) {
            Session::flash('status-warning', 'Something went wrong. please try again!');
            return redirect()->back();
        }
        $response = new TicketResponse();
        $response->user_id = $user->id;
        $response->ticket_id = $ticket_id;
        $response->messageBy = 'You';
        $response->message = $request->message;
        $response->save();
        Ticket::whereId($ticket_id)->update(['status'=>0]);
        $activity = new Activity();
        $activity->user_id = $user->id;
        $activity->type = 'account';
        $activity->description = 'You responded to the ticket: ' . $check->subject . '.';
        $activity->save();
        Session::flash('status', 'You have successfully responded to this ticket!');
        return redirect()->back();
    }

    public function show($id)
    {
        $user = Auth::user();
        $ticket = Ticket::whereId($id)->where('user_id', $user->id)->first();
        if($ticket == null) {
            Session::flash('status-warning', 'Something went wrong. please try again!');
            return redirect()->back();
        }
        $ticketResponses = TicketResponse::where('user_id', $user->id)->where('ticket_id', $ticket->id)->get();
        return view('dashboard.tickets.show', compact('ticket', 'ticketResponses', 'user'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $check = Ticket::whereId($id)->where('user_id', $user->id)->first();
        if($check == null) {
            Session::flash('status-warning', 'Something went wrong. please try again!');
            return redirect()->back();
        } else {
            Session::flash('status', 'Ticket successfully removed!');
            $check->delete();
            return redirect()->back();
        }
    }
}
