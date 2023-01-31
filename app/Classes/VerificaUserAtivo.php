<?php

namespace App\Classes;

use App\Models\Pagamento;
use App\Models\User;
use Carbon\Carbon;

class VerificaUserAtivo
{
    public static function verificaPagamento($user_id)
    {
        $now = Carbon::now();
        $pagamento = Pagamento::where(['user_id'=>$user_id, 'status'=>'1'])->orderBy('id','desc')->first();
        if($pagamento){
            $created_at = \Carbon\Carbon::parse($pagamento->updated_at->format('Y-m-d H:i:s'));
            $diffDays = $created_at->diffInDays($now->format('Y-m-d H:i:s'));
            if($pagamento->tipo == 'adesao' && $diffDays <= 60) {
                return true;
            }elseif($pagamento->tipo == 'renovacao' && $diffDays >= 30) {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function redeUsuario($user_id)
    {
        $user = User::select('id','username','indicacao')->find($user_id);
        $countUsers = User::where('ativo','!=','0')->count();
        $matriz = array($user->username);
        $conta = 0;
        for($a=0;$a<=$countUsers;$a++){
            //echo $matriz[$a]. "<br/>";
            if(empty($matriz[$a])){
                break;
            }else{
                $users = User::select('id','username','indicacao')->where('indicacao',$matriz[$a])->get();
                foreach ($users as $user){
                    $pagamento = \App\Classes\VerificaUserAtivo::verificaPagamento($user->id);
                    if($pagamento){
                        //echo "id: ".$user->id." ". $user->username. " S <br/>";
                        $conta += 1;
                        array_push($matriz,$user->username);
                        if($conta == 1) break;
                    }
                }
            }
        }
        return $conta;
    }
}
