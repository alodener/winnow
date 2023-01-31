<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCadastro extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     * @param User $user
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nao-responda@rollovergreen365.net',config('app.name', 'Laravel'))
            ->markdown('emails.cadastro')
            ->subject('Bem-vindo a '.config('app.name', 'Laravel').'!')
            ->with([
                'user'  => $this->user,
                'url'   => route('home'),
            ]);
    }
}
