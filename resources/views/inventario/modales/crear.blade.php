<div class="modal fade" id="modalIngreso" tabindex="-1" aria-labelledby="modalIngresoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('ingreso.guardar') }}" method="POST">
                @csrf
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalIngresoLabel">Registrar Ingreso de Producto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="codigo" class="form-label">Código del Producto</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="categoria" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="categoria" name="categoria" required>
                        </div>
                        <div class="col-md-6">
                            <label for="proveedor" class="form-label">Proveedor</label>
                            <input type="text" class="form-control" id="proveedor" name="proveedor" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cantidad_ingresada" class="form-label">Cantidad Ingresada</label>
                            <input type="number" class="form-control" id="cantidad_ingresada" name="cantidad_ingresada" required min="1">
                        </div>
                        <div class="col-md-6">
                            <label for="valor_unitario" class="form-label">Valor Unitario</label>
                            <input type="number" step="0.01" class="form-control" id="valor_unitario" name="valor_unitario" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="porcentaje_ganancia" class="form-label">Porcentaje de Ganancia (%)</label>
                            <input type="number" step="0.01" class="form-control" id="porcentaje_ganancia" name="porcentaje_ganancia" required>
                        </div>
                        <div class="col-md-6">
                            <label for="valor_venta" class="form-label">Valor de Venta (calculado)</label>
                            <input type="number" step="0.01" class="form-control" id="valor_venta" name="valor_venta" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Registrar Ingreso</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>