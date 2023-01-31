<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImgDocumento extends Model
{
    use HasFactory;
    protected $casts = [
        'id' => 'string'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documento()
	{
	    return $this->belongsTo(Documento::class, 'user_id', 'user_id');
	}

}
