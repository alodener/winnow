<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailApolice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contato@ivcompany.com.br',config('app.name', 'Laravel'))
            ->subject($this->data['subject'])
            ->markdown('emails.apolices')
            //->attach(public_path('pdf/APOLICE_DE_SEGURO.pdf'))
            ->with('data', $this->data);
    }
}
