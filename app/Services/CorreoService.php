<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionCorreo;
use App\Mail\ContactoCorreo;

class CorreoService
{
    /**
     * Envía el correo de restablecimiento de clave a un usuario.
     */

    public function enviarRestablecimientoClave(string $nombre, string $correo, string $claveNueva, string $link = null)
    {
        $mensaje = "Hola {$nombre}, tu nueva contraseña es: {$claveNueva}";

        Mail::to($correo)->send(
            new NotificacionCorreo($mensaje, $link)
        );
    }

    public function enviarCorreoGenerico(string $correo, string $mensaje)
    {
        Mail::to($correo)->send(
            new ContactoCorreo($mensaje)
        );
    }

}
