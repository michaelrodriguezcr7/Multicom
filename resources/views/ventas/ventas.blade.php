@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h2 class="text-center mb-4">Módulo de Ventas</h2>

    <div class="row">
        <!-- Columna izquierda -->
        <div class="col-md-8">

            {{-- Mensajes de error o éxito --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('mensaje'))
                <div class="alert alert-info">{{ session('mensaje') }}</div>
            @endif

            <form id="formVenta" method="POST" action="{{ route('ventas.store') }}">
                @csrf

                <!-- Buscar producto -->
                <div class="form-group position-relative">
                    <label for="producto">Buscar Producto (por código o nombre):</label>
                    <input type="text" id="buscador-producto" class="form-control" placeholder="Código o Nombre del producto" autocomplete="off">
                    <input type="hidden" id="producto_id" name="producto_id">
                    <input type="hidden" id="precio_unitario" name="precio_unitario">
                    <div id="resultado-productos" class="list-group position-absolute w-100" style="z-index: 1000;"></div>
                </div>

                <!-- Tabla carrito -->
                <h4>Carrito de Compras</h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tablaCarrito">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dinámico con JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Nombre del vendedor -->
                <div class="mb-3">
                    <label for="vendedor" class="form-label">Nombre del vendedor</label>
                    <input type="text" name="vendedor" class="form-control" value="{{ Auth::user()->nom_usu }} {{ Auth::user()->ape_usu }}" readonly>
                </div>

                <!-- Imprimir factura -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="imprimir_factura" id="imprimirFactura">
                    <label class="form-check-label" for="imprimirFactura">Imprimir factura</label>
                </div>

                <!-- Detalle oculto -->
                <input type="hidden" name="detalleVenta" id="detalleVenta">

                <!-- Total oculto -->
                <input type="hidden" name="total" id="totalVenta">

                <!-- Usuario oculto -->
                <input type="hidden" name="id_usu" value="{{ Auth::user()->id_usu }}">

                <!-- Botón procesar -->
                <button type="submit" class="btn btn-primary">Procesar Venta</button>
            </form>
        </div>

        <!-- Columna derecha -->
        <div class="col-md-4">
            <div class="border p-3 text-center">
                <h3>Total:</h3>
                <div class="fs-1 fw-bold text-primary border border-primary py-2" id="totalTexto">0</div>

                <label for="pago" class="form-label mt-3">Pago</label>
                <input type="number" class="form-control border-primary text-primary text-center" id="pago" value="0" min="0">

                <h4 class="mt-4">Cambio: <span class="text-success" id="cambioTexto">0.00</span></h4>
            </div>

            <!-- Botón para abrir el modal de ventas -->
            <button class="btn btn-primary mt-4 w-100" data-bs-toggle="modal" data-bs-target="#modalVentas">
                Ver Ventas
            </button>
        </div>
    </div>
</div>


@include('ventas.modales.eliminar')

@endsection

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {
    const buscador = document.getElementById('buscador-producto');
    const resultado = document.getElementById('resultado-productos');
    const tablaCarrito = document.getElementById('tablaCarrito').querySelector('tbody');
    const totalTexto = document.getElementById('totalTexto');
    const cambioTexto = document.getElementById('cambioTexto');
    const pagoInput = document.getElementById('pago');
    const detalleVenta = document.getElementById('detalleVenta');
    const totalVenta = document.getElementById('totalVenta'); // <-- NUEVO

    let carrito = [];

    buscador.addEventListener('input', function () {
        const query = this.value;

        if (query.length < 1) {
            resultado.innerHTML = '';
            return;
        }

        fetch(`/productosx/buscar?query=${query}`)
            .then(response => {
                if (!response.ok) throw new Error("Producto no encontrado");
                return response.json();
            })
            .then(data => {
                resultado.innerHTML = '';
                data.forEach(producto => {
                    const item = document.createElement('a');
                    item.classList.add('list-group-item', 'list-group-item-action');
                    item.textContent = `${producto.codigo} - ${producto.nombre}`;
                    item.dataset.id = producto.id;
                    item.dataset.nombre = producto.nombre;
                    item.dataset.precio = producto.valor_venta;
                    resultado.appendChild(item);
                });
            })
            .catch(error => {
                resultado.innerHTML = '<div class="list-group-item text-danger">Producto no encontrado</div>';
            });
    });

    resultado.addEventListener('click', function (e) {
        if (e.target.tagName === 'A') {
            const id = e.target.dataset.id;
            const nombre = e.target.dataset.nombre;
            const precio = parseFloat(e.target.dataset.precio);

            agregarAlCarrito(id, nombre, precio);
            resultado.innerHTML = '';
            buscador.value = '';
        }
    });

    function agregarAlCarrito(id, nombre, precio) {
        const existente = carrito.find(p => p.id == id);

        if (existente) {
            existente.cantidad += 1;
        } else {
            carrito.push({ id, nombre, precio, cantidad: 1 });
        }

        renderCarrito();
    }

    function eliminarDelCarrito(id) {
        carrito = carrito.filter(p => p.id != id);
        renderCarrito();
    }

    function renderCarrito() {
        tablaCarrito.innerHTML = '';
        let total = 0;

        carrito.forEach(item => {
            const subtotal = item.precio * item.cantidad;
            total += subtotal;

            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${item.nombre}</td>
                <td>
                    <input type="number" class="form-control cantidad-input" value="${item.cantidad}" min="1" data-id="${item.id}">
                </td>
                <td>$${item.precio.toFixed(2)}</td>
                <td>$${subtotal.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm eliminar-btn" data-id="${item.id}">Eliminar</button>
                </td>
            `;
            tablaCarrito.appendChild(fila);
        });

        totalTexto.textContent = `$${total.toFixed(2)}`;
        totalVenta.value = total.toFixed(2); // <-- Aquí se actualiza el total para el backend

        console.log("Contenido detalleVenta:", JSON.stringify(carrito));

        detalleVenta.value = JSON.stringify(carrito);
        calcularCambio();
    }

    tablaCarrito.addEventListener('click', function (e) {
        if (e.target.classList.contains('eliminar-btn')) {
            const id = e.target.dataset.id;
            eliminarDelCarrito(id);
        }
    });

    tablaCarrito.addEventListener('input', function (e) {
        if (e.target.classList.contains('cantidad-input')) {
            const id = e.target.dataset.id;
            const nuevaCantidad = parseInt(e.target.value);

            const producto = carrito.find(p => p.id == id);
            if (producto && nuevaCantidad > 0) {
                producto.cantidad = nuevaCantidad;
                renderCarrito();
            }
        }
    });

    pagoInput.addEventListener('input', calcularCambio);

    function calcularCambio() {
        const total = carrito.reduce((sum, item) => sum + item.precio * item.cantidad, 0);
        const pago = parseFloat(pagoInput.value) || 0;
        const cambio = pago - total;

        cambioTexto.textContent = cambio >= 0 ? `$${cambio.toFixed(2)}` : '$0.00';
    }
});
</script>
@endsection
