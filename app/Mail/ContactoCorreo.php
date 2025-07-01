<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactoCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje; 

    public function __construct($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function build()
    {
        return $this->subject('Notificación de Usuarios')
                    ->view('emails.contacto');
    }
}
