<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financeiro extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function investimentos()
    {
        return $this->belongsTo(Investimento::class, 'investimento_id');
    }

    public function trader()
    {
        return $this->belongsTo(UltimosTraders::class,'trader_id');
    }
}
