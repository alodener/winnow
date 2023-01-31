<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use App\Models\Financeiro;
use App\Models\Notification;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\Saque;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComprovanteStatus;

class SaqueController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin', '2fa']);
    }

    public function index()
	{
		$saques = Saque::where('ativo','0')->paginate(30);
		return view('admin.saques.index', compact('saques'));
	}

	public function show($id)
	{
		$saque = Saque::find($id);
        if(!$saque) return redirect()->route('admin.saques.index')->with('warning','Pedido de Saque nao Existe');
		return view('admin.saques.show', compact('saque'));
	}

	public function aprovados()
	{
		$saques = Saque::where('ativo','1')->orderBy('id','desc')->paginate(30);
		return view('admin.saques.aprovados', compact('saques'));
	}

	public function aprovar(Request $request, $id)
	{
		$saque = Saque::find($id);
		$saque->ativo = "1";
		$saque->update();

        $fin = new Financeiro;
        $fin->user_id = $saque->user_id;
        $fin->tipo = "3";
        $fin->valor = $saque->valor;
        $fin->descricao = "Pedido de Saque Aprovado";
        $fin->saque_id = $saque->id;
        $fin->save();

        /*$user = User::find($saque->user_id);
        $data = array(
            'name'=> $user->name,
            'email'=> $user->email,
            'subject'=> 'Saque Aprovado',
            'message'=> "Seu Saque de R$ ".number_format($saque->valor,2,',','.')." foi Aprovado!",
        );
        Mail::to($user->email)->send(new ComprovanteStatus($data));*/
        $n = new Notification;
        $n->user_id = $saque->user_id;
        $n->title = "Saque Aprovado";
        $n->description = "Seu Saque de R$".$saque->valor." foi Aprovado!";
        $n->readed = "0";
        $n->save();
        return back()->with('success', 'Saque Aprovado com Sucesso!');
	}
    public function reprovar(Request $request, $id)
    {
        $saque = Saque::find($id);
        $saque->ativo = "3";
        $saque->update();

        $fin = new Financeiro;
        $fin->user_id = $saque->user_id;
        $fin->tipo = "3";
        $fin->valor = $saque->valor;
        $fin->descricao = "Pedido de Saque Reprovado";
        $fin->saque_id = $saque->id;
        $fin->save();

        $n = new Notification;
        $n->user_id = $saque->user_id;
        $n->title = "Saque Reprovado";
        $n->description = "Seu Saque de R$".$saque->valor." foi reprovado!";
        $n->readed = "0";
        $n->save();
        return back()->with('success', 'Saque Reprovado com Sucesso!');
    }
    public function estornar(Request $request, $id)
    {
        $config = Configuracao::first();
        $saque = Saque::find($id);

        $wallet = Wallet::select('id','user_id','rendimento','saldo_indicacao','saldo_venda')->where('user_id',$saque->user_id)->first();
        if($saque->desconto < 0){
            $porc = $saque->valor * ($config->taxa_saque/100);
            $valor = $porc+$saque->valor;
            if($saque->tipo == 'rendimento') $wallet->rendimento += $valor;
            if($saque->tipo == 'ganhos_afiliados') $wallet->saldo_indicacao += $valor;
            if($saque->tipo == 'bonus_venda') $wallet->saldo_venda += $valor;
        }else{
            $valor = $saque->desconto+$saque->valor;
            if($saque->tipo == 'rendimento') $wallet->rendimento += $valor;
            if($saque->tipo == 'ganhos_afiliados') $wallet->saldo_indicacao += $valor;
            if($saque->tipo == 'bonus_venda') $wallet->saldo_venda += $valor;
        }
        $wallet->save();

        $fin = new Financeiro;
        $fin->user_id = $saque->user_id;
        $fin->tipo = "3";
        $fin->valor = $saque->valor;
        $fin->descricao = "Pedido de Saque Estornado";
        $fin->saque_id = $saque->id;
        $fin->save();

        $n = new Notification;
        $n->user_id = $saque->user_id;
        $n->title = "Saque Estornado";
        $n->description = "Seu Saque de R$".$saque->valor." foi estornado!";
        $n->readed = "0";
        $n->save();

        $saque->delete();
        return redirect()->route('admin.saques.index')->with('success', 'Saque Estornado com Sucesso!');
    }
}
