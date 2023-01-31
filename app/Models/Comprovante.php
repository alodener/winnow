<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprovante extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pagamentos()
    {
        return $this->belongsTo(Pagamento::class, 'pagamento_id');
    }
}
