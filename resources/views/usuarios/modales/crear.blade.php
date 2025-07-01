<!-- Modal Crear Usuario -->
<div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('usuarios.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crearUsuarioModalLabel">Crear Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label>Cédula</label>
            <input type="text" name="ced_usu" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nom_usu" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="ape_usu" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="tel_usu" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="cor_usu" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Cargo</label>
            <select name="cargo_usu" class="form-control" required>
              <option value="Administrador">Administrador</option>
              <option value="Empleado">Empleado</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="contraseña" class="form-control" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
