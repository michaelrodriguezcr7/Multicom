@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestión de Usuarios</h2>

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearUsuarioModal">Crear Usuario</button>
        <button class="btn btn-success" id="modificarBtn" disabled data-bs-toggle="modal" data-bs-target="#modificarUsuarioModal">Modificar Usuario</button>
    </div>


     {{-- Mensajes de error o éxito --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('mensaje'))
                <div class="alert alert-info">{{ session('mensaje') }}</div>
            @endif
    <!-- Formulario para eliminación múltiple -->
    <form method="POST" action="{{ route('usuarios.eliminar.multiples') }}" id="formEliminar">
        @csrf
        @method('DELETE')


        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th></th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Cargo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>
                            <input type="checkbox"
                                name="ids[]"
                                value="{{ $usuario->id_usu }}"
                                class="checkItem"
                                data-usuario='@json($usuario)'>
                        </td>
                        <td>{{ $usuario->ced_usu }}</td>
                        <td>{{ $usuario->nom_usu }}</td>
                        <td>{{ $usuario->ape_usu }}</td>
                        <td>{{ $usuario->tel_usu }}</td>
                        <td>{{ $usuario->cor_usu }}</td>
                        <td>{{ $usuario->cargo_usu }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <button class="btn btn-danger mt-2" type="submit" id="eliminarBtn" disabled>Eliminar</button>
        <div class="mt-2 text-end">
            <strong>{{ $usuarios->count() }} Usuarios</strong>
        </div>
    </form>
</div>

<!-- Modales (deben existir en views/usuarios/modales/) -->
@include('usuarios.modales.crear')
@include('usuarios.modales.modificar')

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log("🟢 Script de botones cargado");
    const checkAll = document.getElementById('checkAll');
    const checkItems = document.querySelectorAll('.checkItem');
    const modificarBtn = document.getElementById('modificarBtn');
    const eliminarBtn = document.getElementById('eliminarBtn');

    function toggleButtons() {
        const seleccionados = document.querySelectorAll('.checkItem:checked');
        modificarBtn.disabled = seleccionados.length !== 1;
        eliminarBtn.disabled = seleccionados.length === 0;
    }

    if (checkAll) {
        checkAll.addEventListener('change', function () {
            checkItems.forEach(item => item.checked = checkAll.checked);
            toggleButtons();
        });
    }

    checkItems.forEach(item => {
        item.addEventListener('change', toggleButtons);
    });

    toggleButtons(); // al cargar la página

    modificarBtn.addEventListener('click', function () {
        const seleccionado = document.querySelector('.checkItem:checked');
        if (seleccionado) {
            const datos = JSON.parse(seleccionado.dataset.usuario);
            document.getElementById('mod_id_usu').value = datos.id_usu;
            document.getElementById('mod_ced_usu').value = datos.ced_usu;
            document.getElementById('mod_nom_usu').value = datos.nom_usu;
            document.getElementById('mod_ape_usu').value = datos.ape_usu;
            document.getElementById('mod_tel_usu').value = datos.tel_usu;
            document.getElementById('mod_cor_usu').value = datos.cor_usu;
            document.getElementById('mod_cargo_usu').value = datos.cargo_usu;

            const formModificar = document.getElementById('formModificar');
            formModificar.action = `/usuarios/${datos.id_usu}`;
        }
    });
});
</script>
@endsection
