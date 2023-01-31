<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginSecurity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendContatoUser;

class TwoFAController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin', '2fa']);
    }

    public function index()
    {
    	$two2fas = LoginSecurity::orderBy('id','desc')->paginate(20);
    	return view('admin.2fa.index', compact('two2fas'));
    }

    public function ver($id)
    {
    	$twofa = LoginSecurity::find($id);
    	if(!$twofa)
    		return redirect()->route('admin.2fa.index')->with('warning','Usuário não existe');

    	return view('admin.2fa.show', compact('twofa'));
    }

    public function delete($id)
    {
    	$sec = LoginSecurity::find($id);
    	$user = User::find($sec->user_id);
        $data = [
            'name' => $user->name,
            'subject' => "2FA Removido",
            'message' => "A Autenticação de Dois Fatores foi removido da sua conta!"
        ];
        Mail::to($user->email)->send(new SendContatoUser($data));
        $sec->delete();
    	return redirect()->route('admin.2fa.index')->with('success','2FA desativado com Sucesso!');
    }

}
