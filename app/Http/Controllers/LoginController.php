<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Services\CorreoService;


use App\Models\Usuario;

class LoginController extends Controller
{
    // Muestra el formulario de login
    public function formulario()
    {
        if (Auth::check()) {
        return redirect()->route('home');
        }

        // Evita que el navegador almacene esta vista
        return response()->view('auth.login')->header('Cache-Control','no-cache, no-store, must-revalidate');
    }

    // Verifica las credenciales
    public function verificar(Request $request)
    {
        $correo = $request->input('txtlog');
        $clave = md5($request->input('txtcla')); // Asegúrate que las contraseñas están guardadas así

        $usuario = Usuario::where('cor_usu', $correo)
                        ->where('contraseña', $clave)
                        ->first();

        if ($usuario) {
            // Aquí Laravel asocia automáticamente el user_id en la sesión
            Auth::login($usuario);

            return redirect()->route('home'); // O donde desees enviarlo
        } else {
            return redirect()->back()->with('error', 'Credenciales incorrectas');
        }
    }

    // Cierra la sesión
    public function logout(Request $request)
    {
        Auth::logout(); // ⬅️ Cierra la sesión del usuario autenticado
        $request->session()->invalidate(); // Invalida la sesión actual
        $request->session()->regenerateToken(); // Regenera el token CSRF por seguridad

        return redirect()->route('login')->with('mensaje', 'Sesión cerrada correctamente');
    }


   public function restablecer(Request $request)
    {
        // Validar que se haya ingresado un correo válido
        $request->validate([
            'email' => 'required|email'
        ]);

        // Buscar el usuario por el campo cor_usu
        $usuario = Usuario::where('cor_usu', $request->email)->first();

        if ($usuario) {
            // 1. Generar una nueva clave aleatoria
            $claveNueva = Str::random(8);

            // 2. Encriptar la clave con md5
            $usuario->contraseña = md5($claveNueva);

            // 3. Guardar en la base de datos
            $usuario->save();

            // 4. Preparar datos para el correo
            $nombre = $usuario->nom_usu;
            $correo = $usuario->cor_usu;
            $link = url('/login');

            // 5. Usar el servicio para enviar el correo
            $correoService = new CorreoService();
            $correoService->enviarRestablecimientoClave($nombre, $correo, $claveNueva, $link);

            // 6. Retornar al formulario con mensaje
            return back()->with('mensaje', 'Se ha enviado un correo con tu nueva contraseña.');
        }

        return back()->with('error', 'El correo no se encuentra registrado.');
    }



}
