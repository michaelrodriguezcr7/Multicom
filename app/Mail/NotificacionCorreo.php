<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    public $link;

    public function __construct($mensaje, $link = null)
    {
        $this->mensaje = $mensaje;
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('Notificación de System Solvers')
                    ->view('emails.notificacion');
    }
}
