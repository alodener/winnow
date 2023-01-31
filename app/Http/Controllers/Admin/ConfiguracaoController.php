<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigPlano;
use App\Models\Financeiro;
use App\Models\GanhosLicenca;
use App\Models\GerenciaNetConfig;
use App\Models\Investimento;
use App\Models\Pagamento;
use App\Models\TipoBonus;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\Configuracao;
use Str;

class ConfiguracaoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is_admin','2fa']);
    }

    public function index()
    {
    	$configuracao = Configuracao::first();
    	return view('admin.configuracoes.index', compact('configuracao'));
    }

    public function store(Request $request)
    {
    	$configuracao = Configuracao::first();
    	if(!$configuracao){
	    	$c = new Configuracao;
            $c->limite_saque = $request->limite_saque;
            $c->taxa_saque = $request->taxa_saque;
	    	$c->save();
    	}else{
    		$configuracao->limite_saque = $request->limite_saque;
            $configuracao->taxa_saque = $request->taxa_saque;
	    	$configuracao->save();
    	}
    	return redirect()->route('admin.configuracoes.store')->with('success','Configrações Feitas.');
    }

    public function configBonus()
    {
        $bonus = TipoBonus::all();
        return view('admin.configuracoes.bonus.index',compact('bonus'));
    }

    public function configSave(Request $request)
    {
        $config = new TipoBonus();
        $config->name = $request->name;
        $config->tipo = Str::slug($request->name,'-');
        $config->config = [
            'nvl1'  => $request->nvl1,
            'nvl2'  => $request->nvl2,
            'nvl3'  => $request->nvl3,
            'nvl4'  => $request->nvl4,
            'nvl5'  => $request->nvl5,
            'nvl6'  => $request->nvl6,
            'nvl7'  => $request->nvl7,
            'nvl8'  => $request->nvl8,
            'nvl9'  => $request->nvl9,
            'nvl10' => $request->nvl10,
            'nvl11' => $request->nvl11,
            'nvl12' => $request->nvl12,
        ];
        $config->save();
        return redirect()->route('admin.configuracoes.bonus.index')->with('success', 'Configuração de Bônus Criado com Sucesso!');
    }

    public function configEdit($id)
    {
        $config = TipoBonus::find($id);
        return view('admin.configuracoes.bonus.edit',compact('config'));

    }

    public function configUpdate(Request $request, $id)
    {
        $config = TipoBonus::find($id);
        $config->name = $request->name;
        $config->tipo = Str::slug($request->name,'-');
        $config->config = [
            'nvl1'  => $request->nvl1,
            'nvl2'  => $request->nvl2,
            'nvl3'  => $request->nvl3,
            'nvl4'  => $request->nvl4,
            'nvl5'  => $request->nvl5,
            'nvl6'  => $request->nvl6,
            'nvl7'  => $request->nvl7,
            'nvl8'  => $request->nvl8,
            'nvl9'  => $request->nvl9,
            'nvl10' => $request->nvl10,
            'nvl11' => $request->nvl11,
            'nvl12' => $request->nvl12
        ];
        $config->save();
        return redirect()->route('admin.configuracoes.bonus.edit',$id)->with('success', 'Configuração de Bônus Editada com Sucesso!');
    }

    public function configBonusDelete($id)
    {
        TipoBonus::find($id)->delete();
        return redirect()->route('admin.configuracoes.bonus.index')->with('success','Deletado com Sucesso!');
    }

    public function configPlanos()
    {
        $config = ConfigPlano::all();
        return view('admin.configuracoes.planos.index',compact('config'));
    }

    public function configPlanosSave(Request $request)
    {
        $config = new ConfigPlano();
        $config->name = $request->name;
        $config->tipo = Str::slug($request->name,'-');
        $config->save();
        return redirect()->route('admin.configuracoes.planos.index')->with('success', 'Configuração de Plano Criado com Sucesso!');
    }

    public function configPlanosEdit($id)
    {
        $config = ConfigPlano::find($id);
        return view('admin.configuracoes.planos.edit',compact('config'));

    }

    public function configPlanosUpdate(Request $request, $id)
    {
        $config = ConfigPlano::find($id);
        $config->name = $request->name;
        $config->tipo = Str::slug($request->name,'-');
        $config->save();
        return redirect()->route('admin.configuracoes.planos.edit',$id)->with('success', 'Configuração de Planos Editada com Sucesso!');
    }

    public function configSistema()
    {
        $config = Configuracao::first();
        return view('admin.configuracoes.sistema.index',compact('config'));
    }

    public function configSistemaStore(Request $request)
    {
        $config = Configuracao::first();
        $config->update($request->all());
        return redirect()->route('admin.configuracoes.sistema.index')->with('success', 'Configuração de Sistema Editada com Sucesso!');
    }

    public function conversao()
    {
        //$api = json_decode(file_get_contents('https://api.binance.com/api/v1/ticker/price?symbol=TRXUSDT'));
//        $cotacacao = 0.0933;
//
//        $financeiros = Financeiro::select('id')->get();
//        foreach ($financeiros as $f) {
//            $fin = Financeiro::select('id','valor')->find($f->id);
//            $fin->valor = $cotacacao*$fin->valor;
//            $fin->save();
//        }
////        sleep(5);
//        $investimentos = Investimento::select('id')->get();
//        foreach ($investimentos as $i) {
//            $inv = Investimento::select('id','valor','rendimento')->find($i->id);
//            $v = $cotacacao*$inv->valor;
//            $inv->valor = $v;
//            $r = $cotacacao*$inv->rendimento;
//            $inv->rendimento = $r;
//            $inv->save();
//
//        }
//        //sleep(5);
//        $wallets = Wallet::select('id')->get();
//        foreach ($wallets as $w) {
//            $wal = Wallet::select('id','saldo','rendimento')->find($w->id);
//            $wal->saldo = $cotacacao*$wal->saldo;
//            $wal->rendimento = $cotacacao*$wal->rendimento;
//            $wal->save();
//        }

    }

}
