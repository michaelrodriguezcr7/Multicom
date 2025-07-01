<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Services\CorreoService;

class CorreosController extends Controller
{
    public function enviarContacto(Request $request)
    {
        // Validación de campos
        $request->validate([
            'nombre' => 'required|string',
            'correo' => 'required|email',
            'telefono' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        // Armar el contenido del mensaje
        $contenido = "
            <strong>Nombre:</strong> {$request->nombre}<br>
            <strong>Correo:</strong> {$request->correo}<br>
            <strong>Teléfono:</strong> {$request->telefono}<br>
            <strong>Mensaje:</strong><br>{$request->mensaje}
        ";

        // Crear instancia del servicio y enviar correo
        $correoService = new CorreoService();
        $correoService->enviarCorreoGenerico(
            'michaelrxx55@gmail.com', // Correo fijo del destino (System Solvers)
            $contenido
        );

        return back()->with('mensaje', 'Mensaje enviado correctamente. Gracias por contactarnos.');
    }
}
