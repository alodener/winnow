<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatCurso extends Model
{
    use HasFactory;
    public function categorias()
    {
        return $this->belongsTo(Categoria::class,'categoria_id');
    }
}
