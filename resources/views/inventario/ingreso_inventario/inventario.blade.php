@extends('layouts.app')

@section('content')

<div class="container mt-4">
    {{-- Botón de regreso --}}
    <div class="mb-3">
        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
            ⬅️ Volver
        </a>
    </div>

    <h2 class="text-center mb-4">📦 Módulo de Ingresos de Inventario</h2>

    {{-- Mensajes de error o éxito --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('mensaje'))
                <div class="alert alert-info">{{ session('mensaje') }}</div>
            @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Cant. Ingresada</th>
                    <th>Disponible</th>
                    <th>Valor Unitario</th>
                    <th>Ganancia (%)</th>
                    <th>Valor Venta</th>
                    <th>Proveedor</th>
                    <th>Fecha Ingreso</th>
                    <th>Lote</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ingresos as $ing)
                    <tr>
                        <td>{{ $ing->id }}</td>
                        <td>{{ $ing->producto->nombre ?? 'N/A' }}</td>
                        <td>{{ $ing->cantidad_ingresada }}</td>
                        <td>{{ $ing->cantidad_disponible }}</td>
                        <td>${{ number_format($ing->valor_unitario, 2) }}</td>
                        <td>{{ $ing->porcentaje_ganancia }}%</td>
                        <td>${{ number_format($ing->valor_venta, 2) }}</td>
                        <td>{{ $ing->proveedor }}</td>
                        <td>{{ $ing->fecha_ingreso }}</td>
                        <td>{{ $ing->lote }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary mb-1 btn-editar-ingreso"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditarIngreso"
                                data-id="{{ $ing->id }}"
                                data-producto_id="{{ $ing->producto_id }}"
                                data-cantidad="{{ $ing->cantidad_ingresada }}"
                                data-disponible="{{ $ing->cantidad_disponible }}"
                                data-valor="{{ $ing->valor_unitario }}"
                                data-porcentaje="{{ $ing->porcentaje_ganancia }}"
                                data-venta="{{ $ing->valor_venta }}"
                                data-proveedor="{{ $ing->proveedor }}"
                                data-fecha="{{ $ing->fecha_ingreso }}"
                                data-observaciones="{{ $ing->observaciones }}"
                                data-lote="{{ $ing->lote }}">
                            ✏️ Editar
                        </button>


                            <form action="{{ route('ingresos-inventario.destroy', $ing->id) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este ingreso?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">🗑️ Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-muted">No hay ingresos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('inventario.ingreso_inventario.modales.editar')

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalEditarIngreso');
    const form = document.getElementById('formEditarIngreso');

    document.querySelectorAll('.btn-editar-ingreso').forEach(boton => {
        boton.addEventListener('click', () => {
            const id = boton.getAttribute('data-id');
            form.action = `/ingresos-inventario/${id}`;
            document.getElementById('edit_id').value = id;

            const producto_id = boton.getAttribute('data-producto_id');
            document.getElementById('edit_producto_id').value = producto_id;
            document.getElementById('hidden_producto_id').value = producto_id; // 👈 importante para enviar el valor

            document.getElementById('edit_cantidad').value = boton.getAttribute('data-cantidad');
            document.getElementById('edit_disponible').value = boton.getAttribute('data-disponible');
            document.getElementById('edit_valor').value = boton.getAttribute('data-valor');
            document.getElementById('edit_porcentaje').value = boton.getAttribute('data-porcentaje');
            document.getElementById('edit_venta').value = boton.getAttribute('data-venta');
            document.getElementById('edit_proveedor').value = boton.getAttribute('data-proveedor');
            document.getElementById('edit_fecha').value = boton.getAttribute('data-fecha');
            document.getElementById('edit_observaciones').value = boton.getAttribute('data-observaciones');
            document.getElementById('edit_lote').value = boton.getAttribute('data-lote');
        });
    });
});
</script>



@endsection
