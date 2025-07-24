<div class="modal fade" id="modalEditarIngreso" tabindex="-1" aria-labelledby="modalEditarIngresoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('ingresos-inventario.update', $ing->id) }}" id="formEditarIngreso" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalEditarIngresoLabel">✏️ Editar Ingreso de Inventario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body row g-3">
          <input type="hidden" name="id" id="edit_id">

          <div class="col-md-6">
            <label for="edit_producto_id" class="form-label">Producto</label>
            <select name="producto_id" id="edit_producto_id" class="form-select" disabled>
              @foreach($productos as $prod)
                <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
              @endforeach
            </select>
            <input type="hidden" name="producto_id" id="hidden_producto_id">
          </div>

          <div class="col-md-3">
            <label for="edit_cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad_ingresada" id="edit_cantidad" class="form-control" required>
          </div>

          <div class="col-md-3">
            <label for="edit_disponible" class="form-label">Disponible</label>
            <input type="number" name="cantidad_disponible" id="edit_disponible" class="form-control" readonly>
          </div>

          <div class="col-md-4">
            <label for="edit_valor" class="form-label">Valor Unitario</label>
            <input type="number" name="valor_unitario" id="edit_valor" class="form-control" readonly>
          </div>

          <div class="col-md-4">
            <label for="edit_porcentaje" class="form-label">% Ganancia</label>
            <input type="number" name="porcentaje_ganancia" id="edit_porcentaje" class="form-control" readonly>
          </div>

          <div class="col-md-4">
            <label for="edit_venta" class="form-label">Valor Venta</label>
            <input type="number" name="valor_venta" id="edit_venta" class="form-control" readonly>
          </div>

          <div class="col-md-6">
            <label for="edit_proveedor" class="form-label">Proveedor</label>
            <input type="text" name="proveedor" id="edit_proveedor" class="form-control" readonly>
          </div>

          <div class="col-md-6">
            <label for="edit_fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha_ingreso" id="edit_fecha" class="form-control" readonly>
          </div>

          <div class="col-md-6">
            <label for="edit_lote" class="form-label">Lote</label>
            <input type="text" name="lote" id="edit_lote" class="form-control" readonly>
          </div>

          <div class="col-12">
            <label for="edit_observaciones" class="form-label">Observaciones</label>
            <textarea name="observaciones" id="edit_observaciones" class="form-control" rows="2" readonly></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">💾 Guardar cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
