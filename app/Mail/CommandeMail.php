<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommandeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;
    public $commandes;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($commande,$commandes)
    {
        $this->commande = $commande;
        $this->commandes = $commandes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('pdf.facture');
    }
}
