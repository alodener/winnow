<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagamento extends Model
{
    use HasFactory,SoftDeletes;

    //protected $casts = ['descricao'=>'array'];

    protected $dates = ['validate_at'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function planos()
    {
        return $this->belongsTo(Plano::class, 'plano_id');
    }

    public function plano()
    {
        return $this->belongsToMany('plano_id','plano_id');
    }

    public function comprovantes()
    {
        return $this->belongsTo(Comprovante::class, 'pagamento_id');
    }

    public function vouchers()
    {
        return $this->belongsTo(Voucher::class,'voucher_id');
    }

    public function indicacao()
    {
        return $this->belongsTo(User::class,'user_id')->select('id','indicacao','ativo');
    }

    public function verificaFatura()
    {
        return (bool) Fatura::where('pagamento_id',$this->id)->where('status','ACTIVE')
                        ->where('expires_at','<',now())->orderBy('id','desc')->first();
    }
}
