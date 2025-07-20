{{-- Modal para mostrar el listado de ventas --}}
<div class="modal fade" id="modalVentas" tabindex="-1" aria-labelledby="modalVentasLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVentasLabel">Listado de Ventas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        {{-- Mensajes de error o éxito --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('mensaje'))
            <div class="alert alert-info">{{ session('mensaje') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Vendedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->fecha }}</td>
                        <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                        <td>{{ $venta->usuario->nom_usu ?? 'Desconocido' }}</td>
                        <td>
                            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta venta?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No hay ventas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
