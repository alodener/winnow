<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [

        'id',
        'user_id',
        'title',
        'description',
        'readed'

    ];

    protected $dates = ['created_at'];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
