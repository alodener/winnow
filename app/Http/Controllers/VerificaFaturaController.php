<?php

namespace App\Http\Controllers;

use App\Classes\ClubeCertoAction;
use App\Models\ClubeCerto;
use App\Models\Pagamento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerificaFaturaController extends Controller
{
    public function pagamentos()
    {
        $pagamentos = Pagamento::select('id','status')->where('validate_at','<',now())->get();
        foreach ($pagamentos as $p) {
            $pg = Pagamento::find($p->id);
            $pg->status = "3";
            $pg->save();

            $clube = ClubeCerto::where('user_id',$p->user_id)->first();
            if ($clube){
                ClubeCertoAction::inativar($clube->user_id);
                $clube->status = '3';
                $clube->save();
            }
        }
    }

    public function pagamentosVencido()
    {
        $pagamentos = Pagamento::select('id','status','created_at')->where('status','0')->get();
        $now = Carbon::now();
        foreach ($pagamentos as $p) {
            $pg = Pagamento::find($p->id);
            $created_at = \Carbon\Carbon::parse($pg->created_at->format('Y-m-d H:i:s'));
            $diffDays = $created_at->diffInDays($now->format('Y-m-d H:i:s'));
            if($diffDays > 3 && ($p->verificaFatura() == true)){
                $pg->delete();
            }
        }
    }
}
