@extends('layouts.app')
@section('title', 'Inventario Actual')

@section('content')

<h2 class="text-center mb-4">📦 Inventario General (Stock Actual por Producto)</h2>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">📦 Ingresos de Inventario</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('ingresos-inventario.index') }}" class="btn btn-success shadow-sm">
            📄 Ver Ingresos
        </a>
        <button id="btnAbrirModalIngreso" class="btn btn-primary shadow-sm">
            ➕ Nuevo Ingreso
        </button>
    </div>
</div>

{{-- Mensajes flash --}}
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if (session('mensaje'))
    <div class="alert alert-info">{{ session('mensaje') }}</div>
@endif

<div class="container-fluid">
    <div class="card shadow-sm border">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Cantidad Disponible</th>
                        <th>Valor Unitario</th>
                        <th>Proveedor Actual</th>
                        <th>% Ganancia</th>
                        <th>Valor de Venta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $prod)
                        <tr>
                            <td>{{ $prod->codigo }}</td>
                            <td>{{ $prod->nombre }}</td>
                            <td>{{ $prod->categoria }}</td>
                            <td class="text-center">{{ $prod->cantidad_total }}</td>
                            <td>${{ number_format($prod->valor_unitario, 0, ',', '.') }}</td>
                            <td>{{ $prod->proveedor_actual }}</td>
                            <td>{{ $prod->porcentaje_ganancia }}%</td>
                            <td>${{ number_format($prod->valor_venta, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary btn-editar"
                                        data-id="{{ $prod->id }}"
                                        data-codigo="{{ $prod->codigo }}"
                                        data-nombre="{{ $prod->nombre }}"
                                        data-categoria="{{ $prod->categoria }}"
                                        data-proveedor="{{ $prod->proveedor_actual }}"
                                        data-valor_unitario="{{ $prod->valor_unitario }}"
                                        data-porcentaje="{{ $prod->porcentaje_ganancia }}"
                                        data-valor_venta="{{ $prod->valor_venta }}">
                                        ✏️ Editar
                                    </button>

                                    <form action="{{ route('productos.destroy', $prod->id) }}" method="POST"
                                          onsubmit="return confirm('⚠️ Este producto se eliminará junto con todos sus registros de inventario.\n¿Deseas continuar?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@include('inventario.modales.crear')
@include('inventario.modales.modificar') {{-- Modal de edición --}}

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnAbrir = document.getElementById('btnAbrirModalIngreso');
    const modalElement = document.getElementById('modalIngreso');
    const modalIngreso = new bootstrap.Modal(modalElement);

    const campoCodigo = document.getElementById('codigo');

    btnAbrir.addEventListener('click', function () {
        modalElement.querySelectorAll('input:not([type=hidden]), textarea').forEach(el => el.value = '');
        modalIngreso.show();
    });

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
                    calcularValorVenta();
                } else {
                    ['nombre', 'categoria', 'proveedor', 'valor_unitario', 'porcentaje_ganancia', 'valor_venta'].forEach(id => {
                        document.getElementById(id).value = '';
                    });
                }
            })
            .catch(err => console.error('Error al buscar producto:', err));
    });

    function calcularValorVenta() {
        const valorUnitario = parseFloat(document.getElementById('valor_unitario').value) || 0;
        const porcentaje = parseFloat(document.getElementById('porcentaje_ganancia').value) || 0;
        const valorVenta = valorUnitario * (1 + porcentaje / 100);
        document.getElementById('valor_venta').value = valorVenta.toFixed(2);
    }

    document.getElementById('valor_unitario').addEventListener('input', calcularValorVenta);
    document.getElementById('porcentaje_ganancia').addEventListener('input', calcularValorVenta);

    // Abrir modal editar
    const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
    document.querySelectorAll('.btn-editar').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('producto_id').value = this.dataset.id;
            document.getElementById('edit_codigo').value = this.dataset.codigo;
            document.getElementById('edit_nombre').value = this.dataset.nombre;
            document.getElementById('edit_categoria').value = this.dataset.categoria;
            document.getElementById('edit_proveedor').value = this.dataset.proveedor;
            document.getElementById('edit_valor_unitario').value = this.dataset.valor_unitario;
            document.getElementById('edit_porcentaje').value = this.dataset.porcentaje;
            document.getElementById('edit_valor_venta').value = this.dataset.valor_venta;

            document.getElementById('formEditar').action = `/productos/${this.dataset.id}`;
            modalEditar.show();
        });
    });

    // Calcular valor de venta en edición
    document.getElementById('edit_valor_unitario').addEventListener('input', calcularVentaEdit);
    document.getElementById('edit_porcentaje').addEventListener('input', calcularVentaEdit);

    function calcularVentaEdit() {
        const val = parseFloat(document.getElementById('edit_valor_unitario').value) || 0;
        const por = parseFloat(document.getElementById('edit_porcentaje').value) || 0;
        document.getElementById('edit_valor_venta').value = (val + (val * por / 100)).toFixed(2);
    }
});
</script>
@endsection
