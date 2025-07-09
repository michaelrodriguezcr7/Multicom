<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Producto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="producto_id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_codigo" class="form-label">Código del Producto</label>
                            <input type="text" class="form-control" id="edit_codigo" name="codigo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_categoria" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="edit_categoria" name="categoria" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_proveedor" class="form-label">Proveedor</label>
                            <input type="text" class="form-control" id="edit_proveedor" name="proveedor_actual" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_valor_unitario" class="form-label">Valor Unitario</label>
                            <input type="number" step="0.01" class="form-control" id="edit_valor_unitario" name="valor_unitario" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_porcentaje" class="form-label">Porcentaje de Ganancia (%)</label>
                            <input type="number" step="0.01" class="form-control" id="edit_porcentaje" name="porcentaje_ganancia" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_valor_venta" class="form-label">Valor de Venta (calculado)</label>
                        <input type="number" step="0.01" class="form-control" id="edit_valor_venta" name="valor_venta" readonly>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">💾 Guardar Cambios</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
