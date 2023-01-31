<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class RedeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $diretos = User::select('id','name','username','ativo','created_at')->where('indicacao',Auth::user()->username)->where('ativo','1')->get();
        $ativosCount = User::where('indicacao',Auth::user()->username)->where('ativo','1')->count();
        $pendentesCount = User::where('indicacao',Auth::user()->username)->where('ativo','!=','1')->count();
        $indicacaoCount = User::where('indicacao',Auth::user()->username)->count();
        $countUsers = User::count();
        $matriz = array(Auth::user()->username);
        for($a=0;$a<=$countUsers;$a++){
            //echo $matriz[$a]. "<br/>";
            if(empty($matriz[$a])){
                break;
            }else{
                $users = User::select('username','indicacao')->where('indicacao',$matriz[$a])->get();
                foreach ($users as $user){
                    //echo $user. "<br/>";
                    array_push($matriz,$user->username);
                    $matriza[] = $user;
                }
            }
        }
        $containdiretos = count($matriz);
        $indiretosCoun = $containdiretos - 1;
        return view('dashboard.redes.index',compact('diretos','indicacaoCount','ativosCount','pendentesCount','indiretosCoun'));
    }

    public function pendentes()
    {
        $pendentes = User::select('id','name','username','ativo','created_at')->where('indicacao',Auth::user()->username)->where('ativo','!=','1')->get();
        $indicacaoCount = User::where('indicacao',Auth::user()->username)->count();
        $ativosCount = User::where('indicacao',Auth::user()->username)->where('ativo','1')->count();
        $pendentesCount = User::where('indicacao',Auth::user()->username)->where('ativo','!=','1')->count();
        return view('dashboard.redes.pendentes',compact('pendentes','indicacaoCount','ativosCount','pendentesCount'));
    }

    public function redeDireto($username)
    {
        $direto = User::select('name','indicacao')->where('username',$username)->first();
        if(!$direto){
            return redirect()->route('dashboard.redes.diretos')->with('warning','Error!');
        }
        if($direto->indicacao != Auth::user()->username){
            //return redirect()->route('dashboard.redes.diretos')->with('warning','Essa não é sua rede!');
        }
        $redeIndicados = User::select('id','name','username','ativo','created_at')->where('indicacao',$username)->get();
        $countUsers = User::count();
        $matriz = array($username);
        for($a=0;$a<=$countUsers;$a++){
            //echo $matriz[$a]. "<br/>";
            if(empty($matriz[$a])){
                break;
            }else{
                $users = User::select('username','indicacao')->where('indicacao',$matriz[$a])->get();
                foreach ($users as $user){
                    //echo $user. "<br/>";
                    array_push($matriz,$user->username);
                    $matriza[] = $user;
                }
            }
        }
        $containdiretos = count($matriz);
        $indiretosCoun = $containdiretos - 1;
        return view('dashboard.redes.rededireto',compact('redeIndicados','direto','indiretosCoun'));
    }

    public function rede($nvl1, $nvl2 = null, $nvl3 = null, $nvl4 = null, $nvl5 = null)
    {
        if($nvl1 != auth()->user()->username) return redirect()->route('dashboard.redes.diretos')->with('warning','Essa rede não é sua');
        $nivel1 = User::select('name','username','indicacao')->where('username')->first();
    }
}
