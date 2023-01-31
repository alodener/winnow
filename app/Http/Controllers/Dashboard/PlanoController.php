<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Fatura;
use App\Models\Pagamento;
use App\Models\Plano;
use App\Models\Saque;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Hexters\CoinPayment\CoinPayment;
use App\CoinPaymentsAPI;

class PlanoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $planos = Plano::where('status','1')->get(['id','name','body','valor','tipo']);
        return view('dashboard.planos.index',compact('planos'));
    }

    public function addPlano(Request $request)
    {
        $verificaPagamento = Pagamento::where(['user_id'=>\Auth::id(),'status'=>'0'])->orderBy('id','desc')->first();
        if($verificaPagamento){
            return redirect()->route('dashboard.pagamentos.index')->with('warning','Você ainda tem um Investimento Pendente!');
        }
//        $valor = str_replace(',','.', str_replace('.','',$request->valor));
//        if($valor < 100){
//            return back()->with('warning','O valor é menor quem 100,00!');
//        }
        $plano = Plano::find($request->plano_id);

        $pagamento = new Pagamento();
        $pagamento->user_id = Auth::id();
        $pagamento->plano_id = $plano->id;
        $pagamento->valor = $plano->valor;
        $pagamento->tipo = $plano->tipo;
        $pagamento->status = '0';
        $pagamento->save();

        return redirect()->route('dashboard.verPagamento',$pagamento->id)->with('success','Fatura Gerada com Sucesso');
    }

    public function callback(Request $request)
    {
        dd($request->all());
    }

    public function desistencia($id)
    {
        $pagamento = Pagamento::find($id);
        return view('dashboard.planos.desistencia',compact('pagamento'));
    }

    public function desistenciaStore($id)
    {
        $pagamento = Pagamento::find($id);
        if($pagamento->status == "1"){
            if($pagamento->validate_at < date('Y-d-m H:i:S')){
                $pagamento->status = "3";
                $pagamento->save();
                toast('A Lincença está Vencida','warning');
                return redirect()->route('dashboard.produtos.desistencia',$id);
            }else{
                $saque = new Saque();
                $saque->user_id = Auth::id();
                $saque->valor = ($pagamento->valor*60)/100;
                $saque->ativo = "0";
                $saque->tipo = 'desistencia';
                $saque->save();

                $pagamento->status = "5";
                $pagamento->save();

                toast('Desistência da Lincença Concluída','success');
                return redirect()->route('dashboard.produtos.desistencia',$id);
            }

        }else{
            toast('Lincença não está apta!','warning');
            return redirect()->route('dashboard.produtos.desistencia',$id);
        }
    }
}
