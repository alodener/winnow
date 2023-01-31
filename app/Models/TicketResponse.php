<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
    protected $fillable = [

        'id',
        'user_id',
        'ticket_id',
        'messageBy',
        'message',
        'created_at'

    ];

    public function tickets() {
        return $this->belongsTo('App\Ticket');
    }
}
