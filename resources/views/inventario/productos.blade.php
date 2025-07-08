@extends('layouts.app')
@section('title', 'Inventario Actual')

@section('content')

<h3 class="mb-4 text-center">📦 Inventario General (Stock Actual por Producto)</h3>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>📦 Ingresos de Inventario</h3>
    <button id="btnAbrirModalIngreso" class="btn btn-success">
        ➕ Nuevo Ingreso
    </button>
</div>

{{-- Mensajes de error o éxito --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('mensaje'))
                <div class="alert alert-info">{{ session('mensaje') }}</div>
            @endif

<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Cantidad Disponible</th>
                        <th>Valor Unitario</th>
                        <th>Proveedor Actual</th>
                        <th>% Ganancia</th>
                        <th>Valor de Venta</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $prod)
                        <tr>
                            <td>{{ $prod->codigo }}</td>
                            <td>{{ $prod->nombre }}</td>
                            <td>{{ $prod->categoria }}</td>
                            <td>{{ $prod->cantidad_total }}</td>
                            <td>${{ number_format($prod->valor_unitario, 0, ',', '.') }}</td>
                            <td>{{ $prod->proveedor_actual }}</td>
                            <td>{{ $prod->porcentaje_ganancia }}%</td>
                            <td>${{ number_format($prod->valor_venta, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Aquí se incluye el modal que está en otra vista --}}
@include('inventario.modales.crear')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnAbrir = document.getElementById('btnAbrirModalIngreso');
        const modalElement = document.getElementById('modalIngreso');
        const modalIngreso = new bootstrap.Modal(modalElement);

        const campoCodigo = document.getElementById('codigo');

        // 🟢 Abrir modal y limpiar campos
        btnAbrir.addEventListener('click', function () {
            modalElement.querySelectorAll('input:not([type=hidden]), textarea').forEach(el => el.value = '');
            modalIngreso.show();
        });

        // 🔎 Buscar producto al salir del campo código
        campoCodigo.addEventListener('blur', function () {
            const codigo = campoCodigo.value.trim();
            if (codigo === '') return;

            fetch(`/producto/buscar/${codigo}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        document.getElementById('nombre').value = data.nombre;
                        document.getElementById('categoria').value = data.categoria;
                        document.getElementById('proveedor').value = data.proveedor;
                        document.getElementById('valor_unitario').value = data.valor_unitario;
                        document.getElementById('porcentaje_ganancia').value = data.porcentaje_ganancia;

                        calcularValorVenta(); // 🧠 Calcula automáticamente el valor de venta
                    } else {
                        ['nombre', 'categoria', 'proveedor', 'valor_unitario', 'porcentaje_ganancia', 'valor_venta'].forEach(id => {
                            document.getElementById(id).value = '';
                        });
                    }
                })
                .catch(err => console.error('Error al buscar producto:', err));
        });

        // 🧠 Función para calcular valor de venta
        function calcularValorVenta() {
            const valorUnitario = parseFloat(document.getElementById('valor_unitario').value) || 0;
            const porcentaje = parseFloat(document.getElementById('porcentaje_ganancia').value) || 0;

            const valorVenta = valorUnitario * (1 + porcentaje / 100);
            document.getElementById('valor_venta').value = valorVenta.toFixed(2);
        }

        // 🎯 Calcula automáticamente cuando el usuario cambia los valores manualmente
        document.getElementById('valor_unitario').addEventListener('input', calcularValorVenta);
        document.getElementById('porcentaje_ganancia').addEventListener('input', calcularValorVenta);
    });
</script>
@endsection
