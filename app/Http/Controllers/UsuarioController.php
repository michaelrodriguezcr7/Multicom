<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    // 1. Mostrar todos los usuarios
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    // 2. Mostrar formulario para crear (NO LO USAS porque usas modal)
    public function create()
    {
        return view('usuarios.modales.crear'); // o puedes dejarlo vacío
    }

    // 3. Guardar nuevo usuario
    public function store(Request $request)
    {
        Usuario::create([
            'ced_usu' => $request->ced_usu,
            'nom_usu' => $request->nom_usu,
            'ape_usu' => $request->ape_usu,
            'tel_usu' => $request->tel_usu,
            'cor_usu' => $request->cor_usu,
            'cargo_usu' => $request->cargo_usu,
            'contraseña' => md5($request->contraseña)
        ]);

        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario creado');
    }

    // 4. Mostrar un usuario (no lo usas)
    public function show($id)
    {
        return response()->json(Usuario::findOrFail($id));
    }

    // 5. Mostrar formulario para editar (NO LO USAS porque usas modal)
    public function edit($id)
    {
        return view('usuarios.modales.modificar'); // o puedes dejarlo vacío
    }

    // 6. Actualizar usuario
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->ced_usu = $request->ced_usu;
        $usuario->nom_usu = $request->nom_usu;
        $usuario->ape_usu = $request->ape_usu;
        $usuario->tel_usu = $request->tel_usu;
        $usuario->cor_usu = $request->cor_usu;
        $usuario->cargo_usu = $request->cargo_usu;

        if ($request->filled('contraseña')) {
            $usuario->contraseña = md5($request->contraseña);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario actualizado');
    }

    // 7. Eliminar un usuario
    public function destroy($id)
    {
        Usuario::destroy($id);
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado');
    }

    public function eliminarMultiples(Request $request)
    {
        $ids = $request->input('ids'); // Arreglo de ID seleccionados

        if ($ids && count($ids) > 0) {
            Usuario::whereIn('id_usu', $ids)->delete();
            return redirect()->back()->with('mensaje', 'Usuarios eliminados correctamente.');
        }

        return redirect()->back()->with('error', 'No seleccionaste ningún usuario.');
    }

}
