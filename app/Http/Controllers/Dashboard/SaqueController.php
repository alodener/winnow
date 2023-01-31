<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use App\Models\ContaBancaria;
use App\Models\Historico;
use App\Models\ImgDocumento;
use App\Models\Saque;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Log;

class SaqueController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        $saques = Saque::where('user_id', Auth::id())->orderBy('id','desc')->get();
        $contas = ContaBancaria::where('user_id', Auth::id())->get();
        return view('dashboard.financeiros.saque',compact('wallet','saques','contas'));
    }

    public function fazerSaque(Request $request)
    {
//        $imgdocumentos = ImgDocumento::select('user_id','tipo')->where('user_id',Auth::id())->where('status','1')->count();
//        if($imgdocumentos < 3){
//            return redirect()->route('dashboard.validacaoDocumentos')->with('warning','Insira seus Documentos para Verificação');
//        }
        $contas = ContaBancaria::where('user_id', Auth::id())->count();
        if($contas < 1){
            return redirect()->route('dashboard.contaBancaria')->with('warning','Insira sua Carteira');
        }
        $config = Configuracao::first();
        if($request->tipo == "rendimento"){
            //if(date('d') != 30) return redirect()->route('dashboard.saques')->with('warning','Não é dia fazer Saque!');
            $this->validate(request(),[
               'saldo' => ['required'],
               'conta_id' => ['required', 'exists:conta_bancarias,id']
            ]);
            $v = str_replace(',','.', str_replace('.','',$request->saldo));

            if ($config->limite_saque <= $v) {
                if ($v == 0) {
                    Alert::error('Valor 0 não pode');
                    return back();
                }
                $wallet = Wallet::where('user_id', auth()->user()->id)->first();
                if ($wallet->saldo == 0) {
                    Alert::error('Você não tem Saldo');
                    return back();
                }
                if ($v > $wallet->saldo) {
                    Alert::error('O valor pedido é maior que o Saldo');
                    return back();
                } else {
                    $saque = new Saque;
                    $saque->user_id = auth()->id();
                    $desconto = ($v * $config->taxa_saque) / 100;
                    $saque_desconto = $v - $desconto;
                    $saque->valor = $saque_desconto;
                    $saque->ativo = "0";
                    $saque->conta_id = $request->conta_id;
                    $saque->tipo = $request->tipo;
                    $saque->desconto = $desconto;
                    $saque->save();

                    $historico = new Historico;
                    $historico->user_id = auth()->id();
                    $historico->saque_id = $saque->id;
                    $historico->total_antes = $wallet->saldo;
                    $historico->total_depois = $wallet->saldo - $v;
                    $historico->tipo = "saldo";
                    $historico->save();

                    $wallet->saldo -= $v;
                    $wallet->save();
                    Alert::success('Solicitação Realizada com Sucesso, Em no máximo 48hs será depositado em sua conta');
                    return back();
                }
            }else{
                Alert::error('Saque está abaixo do permitido!');
                return back();
            }

        }elseif ($request->tipo == "ganhos_afiliados"){
            //if(date('d') != 30) return redirect()->route('dashboard.saques')->with('warning','Não é dia fazer Saque!');
            $this->validate(request(),[
                'saldo_indicacao' => ['required'],
                'conta_id' => ['required', 'exists:conta_bancarias,id']
            ]);
            $v = str_replace(',','.', str_replace('.','',$request->saldo_indicacao));

            if ($config->limite_saque <= $v) {
                if ($v == 0) {
                    Alert::error('Valor 0 não pode');
                    return back();
                }
                $wallet = Wallet::where('user_id', auth()->user()->id)->first();
                if ($wallet->saldo_indicacao == 0) {
                    Alert::error('Você não tem Saldo');
                    return back();
                }
                if ($v > $wallet->saldo_indicacao) {
                    Alert::error('O valor pedido é maior que o Saldo');
                    return back();
                } else {
                    $saque = new Saque;
                    $saque->user_id = auth()->id();
                    $desconto = ($v * $config->taxa_saque) / 100;
                    $saque_desconto = $v - $desconto;
                    $saque->valor = $saque_desconto;
                    $saque->ativo = "0";
                    $saque->conta_id = $request->conta_id;
                    $saque->tipo = $request->tipo;
                    $saque->desconto = $desconto;
                    $saque->save();

                    $historico = new Historico;
                    $historico->user_id = auth()->id();
                    $historico->saque_id = $saque->id;
                    $historico->total_antes = $wallet->saldo_indicacao;
                    $historico->total_depois = $wallet->saldo_indicacao - $v;
                    $historico->tipo = $request->tipo;
                    $historico->save();

                    $wallet->saldo_indicacao -= $v;
                    $wallet->save();
                    Alert::success('Solicitação Realizada com Sucesso, Em no máximo 48hs será depositado em sua conta');
                    return back();
                }
            }else{
                Alert::error('Saque está abaixo do permitido!');
                return back();
            }
        }elseif ($request->tipo == "bonus_venda"){
            $this->validate(request(),[
                'saldo_venda' => ['required'],
                'conta_id' => ['required', 'exists:conta_bancarias,id']
            ]);
            $v = str_replace(',','.', str_replace('.','',$request->saldo_venda));

            if ($config->limite_saque <= $v) {
                if ($v == 0) {
                    Alert::error('Valor 0 não pode');
                    return back();
                }
                $wallet = Wallet::where('user_id', auth()->user()->id)->first();
                if ($wallet->saldo_venda == 0) {
                    Alert::error('Você não tem Saldo');
                    return back();
                }
                if ($v > $wallet->saldo_venda) {
                    Alert::error('O valor pedido é maior que o Saldo');
                    return back();
                } else {
                    $saque = new Saque;
                    $saque->user_id = auth()->id();
                    $desconto = ($v * $config->taxa_saque) / 100;
                    $saque_desconto = $v - $desconto;
                    $saque->valor = $saque_desconto;
                    $saque->ativo = "0";
                    $saque->conta_id = $request->conta_id;
                    $saque->tipo = $request->tipo;
                    $saque->desconto = $desconto;
                    $saque->save();

                    $historico = new Historico;
                    $historico->user_id = auth()->id();
                    $historico->saque_id = $saque->id;
                    $historico->total_antes = $wallet->saldo_venda;
                    $historico->total_depois = $wallet->saldo_venda - $v;
                    $historico->tipo = $request->tipo;
                    $historico->save();

                    $wallet->saldo_venda -= $v;
                    $wallet->save();
                    Alert::success('Solicitação Realizada com Sucesso, Em no máximo 48hs será depositado em sua conta');
                    return back();
                }
            }else{
                Alert::error('Saque está abaixo do permitido!');
                return back();
            }
        }
    }
}
