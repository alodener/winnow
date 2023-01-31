<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Financeiro;
use App\Models\Investimento;
use Illuminate\Http\Request;
use DB;

class InvestimentoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
        $investimentos = Investimento::orderBy('id','desc')->paginate(10);
        return view('admin.investimentos.index',compact('investimentos'));
    }

    public function show($id)
    {
        $investimento = Investimento::find($id);
        $financeiros = Financeiro::select('id','user_id','valor','trader_id','created_at')->where('investimento_id',$id)->orderBy('id','desc')->paginate(15);
        return view('admin.investimentos.show',compact('investimento','financeiros'));
    }

    public function alterarData(Request $request, $id)
    {
        $investimento = Investimento::find($id);
        $investimento->status = '0';
        $investimento->validate_at = $request->validate_at;
        $investimento->save();

        return redirect()->route('admin.investimentos.show',$id)->with('success','Data Alterada com Sucesso!');
    }

    public function edit($id)
    {
        $investimento = Investimento::find($id);
        return view('admin.investimentos.edit',compact('investimento'));
    }

    public function update(Request $request, $id)
    {
        $investimento = Investimento::find($id);
        $investimento->valor = str_replace(',','.', str_replace('.','',$request->valor));
        $investimento->rendimento = str_replace(',','.', str_replace('.','',$request->rendimento));
        $investimento->status = $request->status;
        $investimento->tipo = $request->tipo;
        $investimento->validate_at = $request->validade;
        $investimento->save();

        return redirect()->route('admin.investimentos.edit',$id)->with('success','Atualizado com Sucesso!');
    }

    public function lista(Request $request)
    {
        $get = \Request::get('tipo');
        if($get == 'maior'){
            $lists = Investimento::where('valor','>=','1000')->groupBy('valor')->selectRaw('count(*) as total, valor')->get();
        }elseif($get == 'menor'){
            $lists = Investimento::where('valor','<','999')->groupBy('valor')->selectRaw('count(*) as total, valor')->get();
        }
        return view('admin.investimentos.lista', compact('lists'));
    }
}
