<div class="modal fade" id="modalContacto" tabindex="-1" aria-labelledby="modalContactoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('enviar.contacto') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalContactoLabel">Contáctanos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nombre" class="form-label">Tu nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label">Tu correo</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Tu teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
          </div>
          <div class="mb-3">
            <label for="mensaje" class="form-label">Tu mensaje o inquietud</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
      </div>
    </form>
  </div>
</div>
