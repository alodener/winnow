<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubeCerto extends Model
{
    use HasFactory;
    protected $table = 'clube_certo';

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
