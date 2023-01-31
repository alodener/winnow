<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    public function curso()
    {
        return $this->belongsTo(Curso::class,'curso_id');
    }

    public function isView()
    {
        return (bool) AulaAssistida::where('aula_id',$this->id)->first();
    }
}
