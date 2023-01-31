<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [

        'id',
        'user_id',
        'subject',
        'message',
        'status',
        'created_at',
        'updated_at'

    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticketResponses() {
        return $this->hasMany('App\Models\TicketResponse');
    }
}
