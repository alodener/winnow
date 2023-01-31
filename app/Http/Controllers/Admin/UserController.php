<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ClubeCerto;
use App\Models\IpedUser;
use Illuminate\Http\Request;
use App\Models\Investimento;
use App\Models\Rendimento;
use App\Models\TipoBonus;
use App\Models\Voucher;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Saque;
use App\Models\LoginSecurity;
use App\Models\Pagamento;
use App\Models\Comprovante;
use App\Models\Financeiro;
use Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendContatoUser;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
    	$users = User::select('id','name','username','email','indicacao','ativo','created_at')
                     ->orderBy('id','desc')->paginate(25);
    	return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
    	$user = User::find($id);
    	return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->validate(request(),[
            'name' => ['required', 'string', 'max:191'],
            'celular' => ['required', 'string', 'max:191'],
            'cpf' => ['required', 'string', 'max:191','unique:users'],
            'username' => ['required', 'string', 'max:191', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => preg_replace("/\s+/", "", $data['username']),
            'password' => Hash::make($data['password']),
            'indicacao' => '0',//$data['indicacao'],
            'ativo' => '0',
            'celular'=> preg_replace('/[^0-9]/', '', $data['celular']),
            'cpf'=> preg_replace('/[^0-9]/', '', $data['cpf']),
            'type' => User::DEFAULT_TYPE,
        ]);

        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->saldo = "0.00";
        $wallet->save();

        return redirect()->route('admin.users.create')->with('success','Usuário cadastrado com Sucesso!');

    }

    public function edit($id)
    {
        $user = User::find($id);
        $pagamentos = Pagamento::where('user_id',$id)->where('status','1')->get();
        $pagamentoCount = Pagamento::where('user_id',$id)->where('status','1')->count();
        return view('admin.users.edit', compact('user','pagamentos','pagamentoCount'));
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
            'name' => 'required|min:6|max:191',
            'email' => 'required|email|unique:users,email,'.$id,
            'indicacao' => ['string', 'max:255','exists:users,username'],
            //'password' => 'same:confirm-password'
        ]);

        $data = $request->all();
        if ($data['password'] != null)
            $data['password'] = bcrypt($data['password']);
        else
            unset($data['password']);

        $user = User::find($id);
        $data['celular'] = preg_replace('/[^0-9]/', '', $request->celular);
        $data['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);
        $user->update($data);

        if($user){
            return redirect()->route('admin.users.edit',$user->id)->with('success','Atualizado com Sucesso');
        }
        return redirect()->route('admin.users.edit',$user->id)->with('warning','Ouve um Erro...');
    }

    public function ativacao(Request $request, $username)
    {
        $user = User::find($id);
        $user->ativo = $request->ativo;
        $user->save();
        if($request->ativo == 0){
            $msg = "Usuário desativado com Sucesso!";
        }elseif($request->ativo == 1){
            $msg = "Usuário Ativado com Sucesso!";
        }
        return redirect()->route('admin.users.edit',$username)->with('success',$msg);
    }

    public function ativacaoPorVoucher(Request $request, $username)
    {
        $user = User::find($id);
        $user->ativo = "1";
        $user->save();

        function generateRandomString($length = 10){
            return substr(str_shuffle(str_repeat($x = time() . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
        }
        $voucher = new Voucher();
        $voucher->code = "IV-" . generateRandomString();
        $voucher->user_id = $user->id;
        $voucher->status = '1';
        $voucher->save();

        $fatura = new Pagamento;
        $fatura->user_id = $user->id;
        if($request->tipo == "adesao-iv-turbo-free"){
            $fatura->plano_id = "1";
            $fatura->tipo =  "adesao-iv-turbo-free";
            $fatura->valor = 10;
        }elseif($request->tipo == "cursos"){
            $fatura->plano_id = "20";
            $fatura->tipo =  "cursos";
            $fatura->valor = 235;
        }
        $fatura->status = '1';
        $fatura->voucher_id = $voucher->id;
        $fatura->save();

        $fin = new Financeiro;
        $fin->user_id = $user->id;
        $fin->tipo = "1";
        if($request->tipo == "adesao-iv-turbo-free"){
            $fin->valor = 10;
            $fin->descricao = "Ativação do Plano: ADESÃO IV TURBO FREE";
            $fin->tipo_bonus = "adesao-iv-turbo-free";
        }elseif($request->tipo == "cursos"){
            $fin->valor = 235;
            $fin->descricao = "Ativação do Curso";
            $fin->tipo_bonus = "cursos";
        }
        $fin->save();

        return back()->with('success', 'Aprovado com Sucesso!');
    }

    public function financeiro($id)
    {
        $user = User::find($id);
        $financeiros = Financeiro::where('user_id',$user->id)->orderBy('id','desc')->paginate(25);
        $pagamentos = Financeiro::where(['user_id'=>$user->id,'tipo'=>'1'])->sum('valor');
        $ganhos = Financeiro::where(['user_id'=>$user->id,'tipo'=>'2'])->sum('valor');
        return view('admin.users.financeiros.financeiro',compact('user','financeiros','pagamentos','ganhos'));
    }

    public function faturas($id)
    {
        $user = User::find($id);
        $faturas = Pagamento::where('user_id',$user->id)->orderBy('id','desc')->paginate(25);
        return view('admin.users.financeiros.fatura',compact('user','faturas'));
    }

    public function faturaStatus(Request $request, $id)
    {
        $user = User::find($id);
        $fatura = Pagamento::find($request->fatura_id);
        $fatura->status = $request->status;
        $fatura->save();
        return redirect()->route('admin.users.faturas',$id)->with('success','O Status da Fatura foi alterado com Sucesso!');
    }

    public function saques($id)
    {
        $user = User::find($id);
        $saques = Saque::where('user_id',$user->id)->orderBy('id','desc')->paginate(25);
        return view('admin.users.financeiros.saques',compact('user','saques'));
    }

    public function indicacoes($id)
    {
        $user = User::find($id);
        $indicacoes = User::where('indicacao',$user->username)->paginate(25);
        $indicacoesCount = User::where('indicacao',$user->username)->count();
        return view('admin.users.indicacoes',compact('user','indicacoes','indicacoesCount'));
    }

    public function destroy($id)
    {
    	User::find($id)->delete();
    	Saque::where('user_id',$id)->delete();
    	Financeiro::where('user_id',$id)->delete();
    	LoginSecurity::where('user_id',$id)->delete();
    	Wallet::where('user_id',$id)->delete();
    	Pagamento::where('user_id',$id)->delete();
    	Comprovante::where('user_id',$id)->delete();
        Investimento::where('user_id',$id)->delete();
        ClubeCerto::where('user_id',$id)->delete();
        IpedUser::where('user_id',$id)->delete();

    	return redirect()->route('admin.users.index')->with('success','Excluído com Sucesso');
    }

    public function searchUser()
    {
        $q = \Request::get('q');
        $user = User::where('name','LIKE','%'.$q.'%')
                    ->orWhere('username','LIKE','%'.$q.'%')
                    ->orWhere('email','LIKE','%'.$q.'%')
                    ->orWhere('cpf','LIKE','%'.$q.'%')
                    ->orWhere('id','LIKE','%'.$q.'%')
                    ->get();
        if(count($user) > 0)
            return view('admin.users.search')->withDetails($user)->withQuery($q);
        else
            Alert::error('Usuário Não Encontrado!');
            return view('admin.users.search');
    }

    public function contatoUser(Request $request)
    {
        $user = User::find($request->user_id);
        $data = [
            'name' => $user->name,
            'subject' => $request->subject,
            'message' => $request->message
        ];

        try {
            Mail::to($user->email)->send(new SendContatoUser($data));
            return redirect()->route('admin.users.edit',$request->user_id)->with('success','Email Enviado com Sucesso');
        }catch (\Exception $e){
            return redirect()->route('admin.users.edit',$request->user_id)->with('warning',$e->getMessage());
        }

    }

    public function saldo($id)
    {
        $user = User::with('wallet:user_id,saldo')->find($id);
        return view('admin.users.saldo',compact('user'));
    }

    public function saldoUpdate(Request $request)
    {
        $wallet = Wallet::where('user_id',$request->user_id)->first();
        if(!$wallet){
            return back()->with('Não existe a carteira com saldo','warning');
        }
        $wallet->saldo = str_replace(',','.', str_replace('.','',$request->saldo));
        $wallet->save();

        //$user = User::select('username')->find($request->user_id);

        return redirect()->route('admin.users.saldo',$request->user_id)->with('success','Valores Atualizado com Sucesso');
    }

    public function inativar($id)
    {
        $user = User::find($id)->update(['ativo'=>'3']);

        if(!$user) return redirect()->route('admin.users.edit',$id)->with('success','Usuário não existe');
        $pagamentos = Pagamento::where('user_id',$id)->get();
        foreach ($pagamentos as $p){
            $pg = Pagamento::find($p->id);
            $pg->status = "3";
            $pg->save();
        }
        return redirect()->route('admin.users.edit',$id)->with('success','Usuário Inativo');
    }

    public function logar($id)
    {
        $user = User::find($id);
        Auth::login($user);
        return redirect()->route('home')->with('success','Logado com Sucesso!');
    }
}
