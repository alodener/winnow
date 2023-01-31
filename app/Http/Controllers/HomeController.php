<?php

namespace App\Http\Controllers;

use App\Classes\IpedCursos;
use App\Models\AulaAssistida;
use App\Models\Curso;
use App\Models\Endereco;
use App\Models\Financeiro;
use App\Models\Pagamento;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ImgDocumento;
use App\Models\LoginSecurity;
use Str;
use Carbon\Carbon;
use Alert;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth',]);
    }

    public function index()
    {
        $countUsers = User::count();
        //$countUsers = User::where('indicacao',Auth::user()->username)->count();
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
                }
            }
        }
        //return $matriz;
        $containdiretos = count($matriz);
        $indiretosCoun = $containdiretos - 1;
        $ganhos = Financeiro::select('valor','created_at')->where('user_id',Auth::id())->where('tipo','2')->whereMonth('created_at',date('m'))->get();
        $wallet = Wallet::select('saldo')->where('user_id',Auth::id())->first();
        $afiliadosCount = User::where('indicacao', Auth::user()->username)->count();
        $totaldeganhos = Financeiro::where('tipo','2')->where('user_id', Auth::id())->sum('valor');

        if(Auth::user()->ativo != 1){
            $cursos = IpedCursos::getCourses();
            $cursosCount = count($cursos);
            return view('home2',compact('cursosCount'));
        }else{
            $aulas_assistidas = AulaAssistida::where(['user_id'=>auth()->id(),'completo'=>'0'])->orderBy('id','desc')->first();
            return view('home', compact('wallet','afiliadosCount','totaldeganhos','ganhos','indiretosCoun','aulas_assistidas'));
        }
    }
}
