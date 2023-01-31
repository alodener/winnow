<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Financeiro;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
        $tipo = \Request::get('tipo');
        if($tipo){
            $financeiros = Financeiro::where('tipo_bonus',$tipo)->orderBy('id','desc')->paginate(30);
        }else{
            $financeiros = Financeiro::orderBy('id','desc')->paginate(30);
        }
        return view('admin.financeiros.index',compact('financeiros'));
    }

    public function pagamentos()
    {
        $financeiros = Financeiro::select('id','user_id','tipo','valor','descricao','created_at')->where('tipo','1')->orderBy('id','desc')->paginate(30);
        return view('admin.financeiros.index',compact('financeiros'));

    }
}
