<?php

namespace App\Http\Controllers\Api;

use App\Classes\ClubeCertoAction;
use App\Classes\IpedCursos;
use App\Http\Controllers\Controller;
use App\Models\ClubeCerto;
use App\Models\Fatura;
use App\Models\Financeiro;
use App\Models\IpedUser;
use App\Models\Pagamento;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PagamentoController extends Controller
{
    public function webhook(Request $request)
    {
        //Log::debug($request->all());
        $data = $request->all();
        //dd($data['charge']['transactionID']);
        $fatura = Fatura::where('transactionID',$data['charge']['transactionID'])->first();
        if($fatura){
            if($fatura->status == 'ACTIVE'){
                $fatura->status = "COMPLETED";
                $fatura->save();
                $p = Pagamento::find($fatura->pagamento_id);
                if($p){
                    $p->status = '1';
                    if($p->tipo == 'anual'){
                        $p->validate_at = date('Y-m-d H:i:s', strtotime("+365 days"));
                    }elseif ($p->tipo == 'mensal'){
                        $p->validate_at = date('Y-m-d H:i:s', strtotime("+30 days"));
                    }
                    $p->update();

                    $user = User::find($p->user_id);
                    $user->ativo = '1';
                    $user->save();

                    $fin = new Financeiro;
                    $fin->user_id = $fatura->user_id;
                    $fin->tipo = "1";
                    $fin->valor = $fatura->valor;
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
                                    $indicacoes = 0;
                                    foreach(User::where(['indicacao' => $patrocinador->username,'ativo'=>'1'])->get() as $ind){
                                        $pagamentoInd = Pagamento::where(['user_id'=>$ind->id,'status'=>'1'])->orderBy('id','desc')->first();
                                        if($pagamentoInd) $indicacoes += 1;
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
                                        } elseif ($n == 4 && $indicacoes >= 2) {
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
                                        } elseif ($n == 5 && $indicacoes >= 3) {
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
                                        } elseif ($n == 6 && $indicacoes >= 4) {
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
                                        } elseif ($n == 7 && $indicacoes >= 5) {
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
                                        }elseif ($n == 8 && $indicacoes >= 6) {
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
                                        } elseif ($n == 4 && $indicacoes >= 2) {
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
                                        } elseif ($n == 5 && $indicacoes >= 3) {
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
                                        } elseif ($n == 6 && $indicacoes >= 4) {
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
                                        } elseif ($n == 7 && $indicacoes >= 5) {
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
                                        }elseif ($n == 8 && $indicacoes >= 6) {
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
                                    }elseif($pagamentoPatrocinador->tipo == 'adesao' && $diffDays >= 60){
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
                                array_push($array,$patrocinador->indicacao);
                            }
                        }
                        if($n == 9){
                            break;
                        }
                    }
                }
            }
        }
    }
}
