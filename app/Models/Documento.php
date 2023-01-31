<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $fillable = ['cpf','rg','dados_pessoais','dados_profissionais','outras_informacoes','nascimento'];

    protected $casts = [
        'dados_pessoais' => 'array',
        'dados_profissionais' => 'array',
        'outras_informacoes' => 'array',
    ];
    protected $dates = ['nascimento'];
    
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
