<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\Comprovante;
use App\Models\Fatura;
use App\Models\Historico;
use App\Models\Investimento;
use App\Models\Pagamento;
use App\Models\Saque;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;
use Str;
use App\Models\ContaBancaria;
use App\Models\Financeiro;
use App\Models\LoginSecurity;
use Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use DB;

class FinanceiroController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $financeiros = Pagamento::where('user_id',Auth::id())->get();
        return response()->json(compact('financeiros'));
    }

    public function pagamentos()
    {

//            $comprovante = new Comprovante;
//            $comprovante->id = Str::uuid();
//            $comprovante->user_id = '6';
//            $comprovante->pagamento_id = '8';
//            $comprovante->hash = Str::uuid();
//            $comprovante->status = '0';
//            $comprovante->save();
//        $c = Comprovante::where(['user_id'=>'2','pagamento_id'=>'4'])->first();
//        $c->status = "0";
//        $c->save();
        $pagamentos = Pagamento::where('user_id',Auth::id())->orderBy('id','desc')->paginate(10);
        return view('dashboard.financeiros.index', compact('pagamentos'));
    }

    public function verPagamento($id)
    {
//        $verifica = User::select('cpf','celular')->find(auth()->id());
//        if($verifica->cpf == null){
//            return redirect('/perfil')->with('warning','Preencha seu CPF!');
//        }
//        if($verifica->celular == null){
//            return redirect('/perfil')->with('warning','Preencha com seu Celular!');
//        }
        $pagamento = Pagamento::where('id',$id)->where('user_id',Auth::id())->first();

        if(!$pagamento){
            return redirect()->route('dashboard.pagamentos.index')->with('warning','Fatura não existe!');
        }
        $comprovantes = Comprovante::select('tipo','img_comprovante','created_at')->where('pagamento_id',$id)->get();
        return view('dashboard.financeiros.verPagamento',compact('pagamento','comprovantes'));
    }

    public function store(Request $request)
    {
        $this->validate(request(),[
            'imagem' => 'required|mimes:jpeg,png,jpg,pdf|max:1024',
            //'hash' => ['required',/*'alpha_num',*/'min:11','unique:comprovantes']
        ]);
        $uuid = Str::uuid();
        $imageName = $uuid.'.'.request()->imagem->getClientOriginalExtension();
        request()->imagem->move(public_path('imagem/comprovantes/'), $imageName);

        $comprovante = new Comprovante;
        $comprovante->id = $uuid;
        $comprovante->user_id = Auth::id();
        $comprovante->pagamento_id = $request->pagamento_id;
        $comprovante->tipo = request()->imagem->getClientOriginalExtension();
        $comprovante->img_comprovante = $imageName;
        $comprovante->status = '0';
        $comprovante->save();

        $url = "/financeiros/ver-pagamentos/".$request->pagamento_id;
        return redirect($url)->with('success', 'Comprovante Enviado com Sucesso!');
    }

    public function contaBancaria()
    {
        $contas = ContaBancaria::where('user_id', Auth::id())->get();
        return view('dashboard.financeiros.contabancaria', compact('contas'));
    }

    public function contaBancariaSalvar(Request $request)
    {
        $conta = new ContaBancaria;
        $conta->user_id = Auth::id();
        $conta->conta = [
            "tipo" => $request->tipo,
            "hash" => $request->hash
        ];
//        if($request->tipo == 'neteller'){
//            $conta->conta = [
//                "tipo" => $request->tipo,
//                "email" => $request->email
//            ];
//        }
        $conta->save();
        return redirect()->route('dashboard.contaBancaria')->with('success','Carteira salva com Sucesso');
    }

    public function deletarcontabancaria(Request $request)
    {
        $conta = ContaBancaria::find($request->conta_id);
        $conta->delete();
        return redirect()->route('dashboard.contaBancaria')->with('success','Carteira removida com Sucesso');
    }

    public function historicoTransacoes(Request $request)
    {
        $historicos = Historico::where('user_id',Auth::id())->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])->get();
        $totaldeganhos = Financeiro::select('valor')->where('user_id',Auth::id())->where('tipo','2')->sum('valor');
        $wallet = Wallet::select('saldo','saldo_indicacao')->where('user_id',Auth::id())->first();
        return view('dashboard.financeiros.historico_de_transacao',compact('historicos','totaldeganhos','wallet'));
    }

    public function extratos(Request $request)
    {
        //$historicos = Financeiro::where('user_id',Auth::id())->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])->get();
        //$historicosSum = Financeiro::where('user_id',Auth::id())->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])->sum('valor');
        if($request->ano){
            $historicos = Financeiro::where('user_id',Auth::id())
                                    ->whereYear('created_at',$request->ano)
//                                    ->select(\DB::raw('MONTH(created_at) mes'))
//                                    ->orderBy('mes')->groupBy('mes')
                                    ->orderBy('id','desc')
                                    ->get();
            $get = $request->ano;
        }else{
            $historicos = Financeiro::where('user_id',Auth::id())->whereYear('created_at',date('Y'))->orderBy('id','desc')->get();
            $get = date('Y');
        }
        $totaldeganhos = Financeiro::select('valor')->where('user_id',Auth::id())->where('tipo','2')->sum('valor');
        $wallet = Wallet::select('saldo')->where('user_id',Auth::id())->first();

        return view('dashboard.financeiros.extratos',compact('totaldeganhos','wallet','historicos','get'));
    }

    public function extratos2(Request $request)
    {
        //$historicos = Financeiro::where('user_id',Auth::id())->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])->get();
        //$historicosSum = Financeiro::where('user_id',Auth::id())->whereBetween('created_at', [$request->inicio." 00:00:00", $request->fim." 23:59:59"])->sum('valor');
        if($request->ano){
            $historicos = Financeiro::where('user_id',Auth::id())
                                    ->whereYear('created_at',$request->ano)
                                    ->select(\DB::raw('MONTH(created_at) mes',), \DB::raw('YEAR(created_at) ano',))
                                    ->orderBy('mes')->groupBy('mes')
                                    ->orderBy('id','desc')
                                    ->get();
            $get = $request->ano;
        }else{
            $historicos = Financeiro::where('user_id',Auth::id())
                                    ->whereYear('created_at',date('Y'))
                                    ->select(\DB::raw('MONTH(created_at) mes'), \DB::raw('YEAR(created_at) ano',))
                                    ->orderBy('mes')->groupBy('mes')
                                    ->orderBy('id','desc')
                                    ->get();
            $get = date('Y');
        }
        $totaldeganhos = Financeiro::select('valor')->where('user_id',Auth::id())->where('tipo','2')->sum('valor');
        $wallet = Wallet::select('saldo')->where('user_id',Auth::id())->first();

        return view('dashboard.financeiros.extratos2',compact('totaldeganhos','wallet','historicos','get'));
    }

    public function rendimentos()
    {
        $rendimentos = Financeiro::select('valor','tipo_bonus','created_at')->where('user_id',Auth::id())->orderBy('id','desc')->paginate(20);
        $rendimentosSumCP = Financeiro::where('user_id',Auth::id())->where('tipo_bonus','bonus-copy-trader')->sum('valor');
        $rendimentosSumXM = Financeiro::where('user_id',Auth::id())->where('tipo_bonus','bonus-consultor')->sum('valor');
        return view('dashboard.financeiros.rendimentos.index',compact('rendimentos','rendimentosSumCP','rendimentosSumXM'));
    }

    public function reinvestir()
    {
        $investimento = Investimento::where('user_id',Auth::id())->first();
        $wallet = Wallet::where('user_id',Auth::id())->first();
        $reinvestimentos = Financeiro::where('user_id',Auth::id())->where('descricao','like','Reinvestimento Rollover')->orderBy('id','desc')->paginate(10);
        return view('dashboard.financeiros.reinvestir', compact('investimento','wallet','reinvestimentos'));
    }

    public function reinvestirStore(Request $request)
    {
        $wallet = Wallet::select('id','saldo')->where('user_id',Auth::id())->first();
        $valor = str_replace(',','.', str_replace('.','',$request->valor));
        if($valor < 100) {
            return back()->with('warning','Valor abaixo do permitido');
        }elseif($valor > $wallet->saldo){
            return back()->with('warning','Valor maior que o Saldo');
        }elseif($wallet->saldo < 100){
            return back()->with('warning','o Saldo é menor que R$100,00');
        }

        $p = new Pagamento();
        $p->user_id = auth()->id();
        $p->valor = $valor;
        $p->status = '1';
        $p->validate_at = date('Y-m-d H:i:s', strtotime("+365 days"));
        $p->descricao = "Reinvestimento Rollover";
        $p->save();

        $investimento = new Investimento;
        $investimento->user_id = auth()->id();
        $investimento->pagamento_id = $p->id;
        $investimento->valor = $valor;
        $investimento->status = '0';
        $investimento->rendimento = "0.00";
        $investimento->tipo = "7";
        $investimento->validate_at = date('Y-m-d H:i:s', strtotime("+365 days"));
        $investimento->save();

        $wallet->saldo -= $valor;
        $wallet->save();

        $reinvestimento = $valor;

        $fin = new Financeiro;
        $fin->user_id = Auth::id();
        $fin->tipo = "1";
        $fin->valor = $valor;
        $fin->descricao = "Reinvestimento Rollover";
        $fin->pagamento_id = $p->id;
        $fin->save();

        $nvl1 = User::select('id','username','indicacao')->where('username',auth()->user()->indicacao)->first();
        $pg_nvl1 = Pagamento::where(['user_id'=>$nvl1?$nvl1->id:null,'status'=>'1'])->first();
        if(isset($nvl1) && isset($pg_nvl1)) {
            $valor = ($reinvestimento * 2) / 100;
            $wallet = Wallet::where('user_id', $nvl1->id)->first();
            $wallet->saldo_venda += $valor;
            $wallet->save();

            $fin = new Financeiro();
            $fin->user_id = $nvl1->id;
            $fin->pagamento_id = $p->id;
            $fin->tipo = '2';
            $fin->valor = $valor;
            $fin->descricao = "Bonus de Venda Nivel 1 de " . $p->users->username;
            $fin->tipo_bonus = 'bonus_venda_direta';
            $fin->save();
        }

        $nvl2 = User::select('id','username','indicacao')->where('username',$nvl1?$nvl1->indicacao:null)->first();
        $pg_nvl2 = Pagamento::where(['user_id'=>$nvl2?$nvl2->id:null,'status'=>'1'])->first();
        if(isset($nvl2) && isset($pg_nvl2)) {
            $valor = ($reinvestimento * 1) / 100;

            $wallet = Wallet::where('user_id', $nvl2->id)->first();
            $wallet->saldo_venda += $valor;
            $wallet->save();

            $fin = new Financeiro();
            $fin->user_id = $nvl2->id;
            $fin->pagamento_id = $p->id;
            $fin->tipo = '2';
            $fin->valor = $valor;
            $fin->descricao = "Bonus de Venda Nivel 2 de " . $p->users->username;
            $fin->tipo_bonus = 'indicacao_indireta';
            $fin->save();
        }

        $nvl3 = User::select('id','username','indicacao')->where('username',$nvl2?$nvl2->indicacao:null)->first();
        $pg_nvl3 = Pagamento::where(['user_id'=>$nvl3?$nvl3->id:null,'status'=>'1'])->first();
        if(isset($nvl3) && isset($pg_nvl3)) {
            $valor = ($reinvestimento * 1) / 100;

            $wallet = Wallet::where('user_id', $nvl3->id)->first();
            $wallet->saldo_venda += $valor;
            $wallet->save();

            $fin = new Financeiro();
            $fin->user_id = $nvl3->id;
            $fin->pagamento_id = $p->id;
            $fin->tipo = '2';
            $fin->valor = $valor;
            $fin->descricao = "Bonus de Venda Nivel 3 de " . $p->users->username;
            $fin->tipo_bonus = 'indicacao_indireta';
            $fin->save();
        }

        $nvl4 = User::select('id','username','indicacao')->where('username',$nvl3?$nvl3->indicacao:null)->first();
        $pg_nvl4 = Pagamento::where(['user_id'=>$nvl4?$nvl4->id:null,'status'=>'1'])->first();
        if(isset($nvl4) && isset($pg_nvl4)) {
            $valor = ($reinvestimento * 0.5) / 100;

            $wallet = Wallet::where('user_id', $nvl4->id)->first();
            $wallet->saldo_venda += $valor;
            $wallet->save();

            $fin = new Financeiro();
            $fin->user_id = $nvl4->id;
            $fin->pagamento_id = $p->id;
            $fin->tipo = '2';
            $fin->valor = $valor;
            $fin->descricao = "Bonus de Venda Nivel 4 de " . $p->users->username;
            $fin->tipo_bonus = 'indicacao_indireta';
            $fin->save();
        }

        $nvl5 = User::select('id','username','indicacao')->where('username',$nvl4?$nvl4->indicacao:null)->first();
        $pg_nvl5 = Pagamento::where(['user_id'=>$nvl5?$nvl5->id:null,'status'=>'1'])->first();
        if(isset($nvl5) && isset($pg_nvl5)){
            $valor = ($reinvestimento * 0.5)/100;

            $wallet = Wallet::where('user_id',$nvl5->id)->first();
            $wallet->saldo_venda += $valor;
            $wallet->save();

            $fin = new Financeiro();
            $fin->user_id = $nvl5->id;
            $fin->pagamento_id = $p->id;
            $fin->tipo = '2';
            $fin->valor = $valor;
            $fin->descricao = "Bonus de Venda Nivel 5 de ".$p->users->username;
            $fin->tipo_bonus = 'indicacao_indireta';
            $fin->save();
        }

        return redirect()->route('dashboard.financeiros.reinvestir.index')->with('success','Reivestimento feito com Sucesso!');
    }
}
