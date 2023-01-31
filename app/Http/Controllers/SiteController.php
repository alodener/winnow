<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Artisan;
use App\Models\User;
use App\Models\Wallet;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailCadastro;

use Str;

class SiteController extends Controller
{
    public function index()
    {
        //return redirect()->route('login');
        return view('site.index');
    }

    public function empresa()
    {
        return view('site.empresa');
    }

    public function privacidade()
    {
        return view('site.privacidade');
    }

    public function termos()
    {
        return view('site.termos');
    }

    public function contato()
    {
        return CoinpaymentLogs::all();
        //return view('site.contato');
    }

    public function faq()
    {
        $faqs = Faq::all();
        return view('site.faq',compact('faqs'));
    }

    public function cookies()
    {
        return view('site.cookies');
    }

    public function config()
    {
        $optimize = Artisan::call('optimize:clear');
        $cache_clear = Artisan::call('cache:clear');
        $view_clear = Artisan::call('view:clear');
        $route_clear = Artisan::call('route:clear');
        //$route_cache = Artisan::call('route:cache');
        //$config_cache = Artisan::call('config:cache');
        //return "ok";

        //$u = User::find(100000);
        //$u->type = "admin";
        //$u->save();
        return response()->json(['success'=>'Otimizado com Sucesso']);
    }

    public function indicacao($id)
    {
        $user = User::select('id','name')->where('username',$id)->first();
        if($user){
            return view('indicacao',compact('user'));
        }else{
            $msg = "Usuário Não Existe";
            return view('errors.500', compact('msg'));
       }
    }

    public function registerIndicacao(Request $request)
    {
        //dd($request->all());
        $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'indicacao' => $request->indicacao,
            'username' => 0,
            'password' => Hash::make($request['password']),
            'type' => User::DEFAULT_TYPE
        ]);
        $id = User::find($user->id);
        $id->username = $user->id;
        $id->update();
        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->saldo = "0.00";
        $wallet->saldo_indicacao = "0.00";
        $wallet->bonus_residual = "0.00";
        $wallet->save();
        Mail::to($user->email)->send(new MailCadastro($user));
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('home')->with('sucess','Cadastro Realizado com Sucesso, confira a caixa de email pra ID de Login!');
        }
        //return redirect()->route('home')->with('sucess','Cadastro Realizado com Sucesso, confira a caixa de email pra ID de Login!');
    }
}
