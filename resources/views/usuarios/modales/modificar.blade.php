<!-- Modal Modificar Usuario -->
<div class="modal fade" id="modificarUsuarioModal" tabindex="-1" aria-labelledby="modificarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="formModificar" action="">
      @csrf
      @method('PUT')
      <input type="hidden" name="id_usu" id="mod_id_usu">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modificarUsuarioModalLabel">Modificar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label>Cédula</label>
            <input type="text" name="ced_usu" id="mod_ced_usu" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nom_usu" id="mod_nom_usu" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="ape_usu" id="mod_ape_usu" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="tel_usu" id="mod_tel_usu" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="cor_usu" id="mod_cor_usu" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Cargo</label>
            <select name="cargo_usu" id="mod_cargo_usu" class="form-control" required>
              <option value="Administrador">Administrador</option>
              <option value="Empleado">Empleado</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="contraseña" id="mod_contraseña" class="form-control">
            <small class="text-muted">Deja vacío si no deseas cambiarla.</small>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Actualizar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
