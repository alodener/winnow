<?php

namespace App\Http\Controllers\Admin;

use App\Classes\ClubeCertoAction;
use App\Classes\IpedCursos;
use App\Classes\VerificaUserAtivo;
use App\Http\Controllers\Controller;
use App\Models\ClubeCerto;
use App\Models\Fatura;
use App\Models\Financeiro;
use App\Models\IpedUser;
use App\Models\Pagamento;
use App\Models\Comprovante;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Wallet;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComprovanteStatus;
use File;
use App\Models\Configuracao;
use Auth;
use DB;

class PagamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is_admin']);
    }

    public function index()
    {
        $pagamentos = Pagamento::orderBy('id','desc')->paginate(20);
        return view('admin.pagamentos.index',compact('pagamentos'));
    }

    public function comprovantes()
    {
        $comprovantes = Comprovante::where('status','0')->paginate(10);
        return view('admin.pagamentos.comprovantes', compact('comprovantes'));
    }

    public function ativos()
    {
        $ativos = Pagamento::where('status','1')->orderBy('updated_at','desc')->paginate(20);
        return view('admin.pagamentos.ativos', compact('ativos'));
    }

    public function pendentes()
    {
        $pendentes = Pagamento::where('status','0')->orderBy('id','desc')->paginate(20);;
        return view('admin.pagamentos.pendentes', compact('pendentes'));
    }

    public function show($id)
    {
        $p = Pagamento::find($id);
        if(!$p){
            return redirect()->route('admin.pagamentos.pendentes')->with('warning','Pagamento não Existe!');
        }
        return view('admin.pagamentos.show', compact('p'));
    }

    public function pagamento($id)
    {
        $p = Pagamento::find($id);
        $config = Configuracao::first();
        if(!$p){
            return redirect()->route('admin.pagamentos.pendentes')->with('warning','Pagamento não Existe!');
        }else if($p->status === '1'){
            return redirect()->route('admin.pagamentos.pendentes')->with('warning','Pagamento já foi Efetuado!');
        }else{
            $p->status = '1';
            if($p->tipo == 'anual'){
                $p->validate_at = date('Y-m-d H:i:s', strtotime("+365 days"));
            }elseif ($p->tipo =='mensal'){
                $p->validate_at = date('Y-m-d H:i:s', strtotime("+30 days"));
            }
            $p->descricao = "Ativo por Admin ".Auth::user()->username;
            $p->update();

            $user = User::find($p->user_id);
            $user->ativo = '1';
            $user->save();

            $fatura = Fatura::where('pagamento_id',$p->id)->first();
            if ($fatura){
                $fatura->status = "COMPLETED";
                $fatura->update();
            }

            $fin = new Financeiro;
            $fin->user_id = $p->user_id;
            $fin->tipo = "1";
            $fin->valor = $p->valor;
            $fin->descricao = "Ativação da Fatura";
            $fin->save();

            $clube = ClubeCerto::where('user_id',$p->user_id)->first();
            if ($clube){
                if($clube->status == '3'){
                    $clube_user = ClubeCertoAction::ativar($p->user_id);
                    $clube->status = '1';
                    $clube->save();
                }
            }else{
                $clube = new ClubeCerto();
                $clube->user_id = $p->user_id;
                $clube->status = "0";
                $clube->save();
            }

            $iped = IpedUser::where('user_id',$p->user_id)->first();
            $msg = '';
            if($iped){
                if($p->tipo == 'adesao'){
                    $iped->course_plan = '2';
                }else{
                    $iped->course_plan = '1';
                }
                $iped->status = "1";
                $iped->save();
            }else{
                $verificaCPF = User::find($p->user_id);
                if($verificaCPF->cpf == null){
                    $msg .= "Sem CPF";
                }else{
                    function generateRandomString($length = 8) {
                        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
                    }
                    $cursos_id = [];
                    $cursos = IpedCursos::getCourses();
                    foreach ($cursos as $course) {
                        $cursos_id [] = $course['course_id'];
                    }
                    $iped = new IpedUser();
                    $iped->user_id = $p->user_id;
                    $iped->course_id = $cursos_id;
                    if($p->tipo == 'adesao'){
                        $iped->course_plan = '2';
                    }else{
                        $iped->course_plan = '1';
                    }
                    $iped->user_name = $p->users->name;
                    $iped->user_email = $p->users->email;
                    $iped->user_cpf = $p->users->cpf;
                    $iped->user_password = generateRandomString();
                    $iped->status = '0';
                    $iped->save();
                }
            }

            $countUsers = User::where('ativo','!=','0')->count();
            $in = User::select('username','indicacao')->where('username',$p->users->username)->first();
            $n = 1;
            $array = array($in->indicacao);
            $now = Carbon::now();

            for($i=0;$i<=$countUsers;$i++){
                if(empty($array[$i])){
                    break;
                }else{
                    $patrocinador = User::select('id','username','indicacao')->where('ativo','!=','0')->where('username',$array[$i])->first();
                    if(isset($patrocinador->id)){
                        $pagamentoPatrocinador = Pagamento::where(['user_id'=>$patrocinador->id,'status'=>'1'])->orderBy('id','desc')->first();
                        if($pagamentoPatrocinador ){
                            $indicacoesCount = 0;
                            $indicacoes = User::select('id','username')->where(['indicacao' => $patrocinador->username,'ativo'=>'1'])->get();
                            if(count($indicacoes) >= 2){
                                foreach($indicacoes as $ind){
                                    $verificaPagamento = VerificaUserAtivo::verificaPagamento($ind->id);
                                    if($verificaPagamento){
                                        $indicacoesCount += 1;
                                    }else{
                                        $indicacoesCount += VerificaUserAtivo::redeUsuario($ind->id);
                                    }
                                }
                            }
                            $created_at = \Carbon\Carbon::parse($pagamentoPatrocinador->updated_at->format('Y-m-d H:i:s'));
                            $diffDays = $created_at->diffInDays($now->format('Y-m-d H:i:s'));
                            if($pagamentoPatrocinador->tipo == 'adesao' && $diffDays <= 60) {
                                if ($n == 1) {
                                    $valor = ($p->valor * 20) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_direta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 2) {
                                    $valor = ($p->valor * 10) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 3) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 4 && $indicacoesCount >= 2) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 5 && $indicacoesCount >= 3) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 6 && $indicacoesCount >= 4) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 7 && $indicacoesCount >= 5) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                }elseif ($n == 8 && $indicacoesCount >= 6) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                }

                            }elseif($pagamentoPatrocinador->tipo == 'renovacao' && $diffDays <= 30){
                                if ($n == 1) {
                                    $valor = ($p->valor * 20) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_direta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 2) {
                                    $valor = ($p->valor * 10) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 3) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 4 && $indicacoesCount >= 2) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 5 && $indicacoesCount >= 3) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 6 && $indicacoesCount >= 4) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                } elseif ($n == 7 && $indicacoesCount >= 5) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                }elseif ($n == 8 && $indicacoesCount >= 6) {
                                    $valor = ($p->valor * 5) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_indireta';
                                    $fin->save();
                                    $n += 1;
                                }
                            }elseif($pagamentoPatrocinador->tipo == 'adesao' && $diffDays > 60){
                                if ($n == 1){
                                    $valor = ($p->valor * 20) / 100;
                                    $wallet = Wallet::where('user_id', $patrocinador->id)->first();
                                    $wallet->saldo += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $patrocinador->id;
                                    $fin->pagamento_id = $p->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Bonus de Venda Nivel ".$n." de " . $p->users->username;
                                    $fin->tipo_bonus = 'indicacao_direta';
                                    $fin->save();
                                    $n += 1;
                                }
                            }
                        }
                        array_push($array,$patrocinador->indicacao);
                    }
                }
                if($n == 9){
                    break;
                }
            }
            return redirect()->route('admin.pagamentos.show',$p->id)->with('success',$msg.' Fatura Ativa com Sucesso!');
        }
    }

    public function aprovarComprovante(Request $request,$id)
    {
        return redirect()->back();
        $c = Comprovante::find($id);
        $pagamento = Pagamento::find($c->pagamento_id);
        if($pagamento->status == '1'){
            return redirect()->route('admin.pagamentos.index')->with('warning','Fatura já está ativada!');
        }

        $user = User::find($c->user_id);
        if($request->status == '1'){
            $c->status = '1';
            $c->update();

            $p = Pagamento::find($c->pagamento_id);
            $p->status = '1';
            $p->validate_at = date('Y-m-d H:i:s', strtotime("+365 days"));
            $p->update();

            $user->ativo = '1';
            $user->update();

            $fin = new Financeiro;
            $fin->user_id = $c->user_id;
            $fin->tipo = "1";
            $fin->valor = $p->valor;
            $fin->descricao = "Ativação da Fatura";
            $fin->save();



//            $data = array(
//                'name'=> $user->name,
//                'email'=> $user->email,
//                'subject'=> 'Comprovante e Pagamento Aprovado',
//                'message'=> "Seu Comprovante e Pagamento foi Aprovado!",
//            );
//            Mail::to($user->email)->send(new ComprovanteStatus($data));
//            $n = new Notification;
//            $n->user_id = $c->user_id;
//            $n->title = "Comprovante Aprovado";
//            $n->description = "Seu Comprovante foi Aprovado!";
//            $n->readed = "0";
//            $n->save();
            return back()->with('success', 'Aprovado com Sucesso!');
        }elseif($request->status == '3'){
            File::delete(public_path('imagem/comprovantes').$c->img_comprovante);
            $c->delete();
            $data = array(
                'name'=> $user->name,
                'email'=> $user->email,
                'subject'=> 'Comprovante Rejeitado',
                'message'=> "Seu Comprovante foi rejeitado!",
            );
            Mail::to($user->email)->send(new ComprovanteStatus($data));
            $n = new Notification;
            $n->user_id = $c->user_id;
            $n->title = "Comprovante Rejeitado";
            $n->description = "Seu Comprovante foi Rejeitado!";
            $n->readed = "0";
            $n->save();
            return back()->with('success', 'Rejeitado com Sucesso!');
        }elseif($request->status == '5'){
            File::delete(public_path('imagem/comprovantes').$c->img_comprovante);
            $c->delete();
            $data = array(
                'name'=> $user->name,
                'email'=> $user->email,
                'subject'=> 'Comprovante Excluído',
                'message'=> "Seu Comprovante foi escluído por não cumprir com as normas da ".config('app.name', 'Laravel')."!",
            );
            Mail::to($user->email)->send(new ComprovanteStatus($data));
            $n = new Notification;
            $n->user_id = $c->user_id;
            $n->title = "Comprovante Excluído";
            $n->description = "Seu Comprovante foi Excluído por não cumprir com as normas da Royal Black Traders!";
            $n->readed = "0";
            $n->save();
            return back()->with('success', 'Deletado com Sucesso!');
        }
        return back()->with('success', 'OK!');
    }

    public function ativarPorVoucher(Request $request, $id)
    {
        $p = Pagamento::find($id);

        if(!$p){
            return redirect()->route('admin.pagamentos.pendentes')->with('error','Pagamento não Existe!');
        }else if($p->status === '1'){
            return redirect()->back()->with('warning','Pagamento já foi Ativado!');
        }else {
            $p->status = "1";
            $p->voucher_id = "1";
            $p->validate_at = date('Y-m-d H:i:s', strtotime("+365 days"));
            $p->update();

            $fin = new Financeiro;
            $fin->user_id = $p->user_id;
            $fin->tipo = "1";
            $fin->valor = $p->valor;
            $fin->descricao = "Ativação da Fatura por Voucher";
            $fin->pagamento_id = $p->id;
            $fin->save();

            $user = User::find($p->user_id);
            $user->ativo = '1';
            $user->update();

            $n = new Notification;
            $n->user_id = $p->user_id;
            $n->title = "Fatura Ativada";
            $n->description = "Sua Fatura foi Aprovada!";
            $n->readed = "0";
            $n->save();

            return back()->with('success', 'Ativado com Sucesso!');
        }
    }

    public function destroy($id)
    {
        Pagamento::find($id)->delete();
        Comprovante::where('pagamento_id',$id)->delete();
        Financeiro::where('pagamento_id',$id)->delete();
        return redirect()->route('admin.pagamentos.pendentes')->with('success','Fatura Excluída com Sucesso');
    }

    public function editFatura($id)
    {
        $pagamento = Pagamento::find($id);

        return view('admin.users.financeiros.editfatura',compact('pagamento'));
    }

    public function updateFatura(Request $request, $id)
    {
        \DB::update('update pagamentos set status = ? , updated_at = ? where id = ?', [$request->status , $request->updated_at , $id]);
        return redirect()->route('admin.pagamentos.edit',$id)->with('warning','Atualizado com Sucesso!');
    }
}
