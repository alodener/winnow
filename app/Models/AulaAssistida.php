<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaAssistida extends Model
{
    use HasFactory;
    protected $casts = ['player'=> 'array'];
}
