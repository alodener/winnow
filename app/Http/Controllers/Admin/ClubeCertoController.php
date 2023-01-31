<?php

namespace App\Http\Controllers\Admin;

use App\Classes\ClubeCertoAction;
use App\Http\Controllers\Controller;
use App\Models\ClubeCerto;
use Illuminate\Http\Request;

class ClubeCertoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is_admin']);
    }

    public function index()
    {
        $users = ClubeCerto::orderByRaw('(status = 1) asc')->orderBy('id','desc')->paginate(10);
        return view('admin.clubecerto.index',compact('users'));
    }

    public function ativar($user_id)
    {
        $user = ClubeCerto::where(['user_id'=>$user_id])->first();
        if($user->status == '1') return redirect()->back()->with('warning','Esse Usário já está ativo!');
        return ClubeCertoAction::ativar($user_id);
    }

    public function inativar($user_id)
    {
        $user = ClubeCerto::where(['user_id'=>$user_id])->first();
        if($user->status == '3') return redirect()->back()->with('warning','Esse Usário já está ativo!');
        return ClubeCertoAction::inativar($user_id);
    }
}
