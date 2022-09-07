<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateUserMailNotif extends Mailable
{
    use Queueable, SerializesModels;

    public $userInfo ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userInfo)
    {
        $this->userInfo = $userInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('VOS INFORMATIONS DE CONNEXION POUR L\'APPLICATION ETS.GN')
            ->view('emails.register');
    }
}
