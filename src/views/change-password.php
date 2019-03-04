<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <form id="my-form" action="api/password-update.php" method="post">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="old">Contraseña Actual</label>
            <input type="password" class="form-control" id="old" name="old" placeholder="********">
            <div id="old-error" class="p-2">
              <small id="old-error-text" class="text-danger"></small>
            </div>
          </div>

          <div class="form-group">
            <label for="new">Nueva Contraseña</label>
            <input type="password" class="form-control" id="new" name="new" placeholder="********">
            <div id="new-error" class="p-2">
              <small id="new-error-text" class="text-danger"></small>
            </div>
          </div>

          <div class="form-group">
            <label for="old">Confirmar Nueva Contraseña</label>
            <input type="password" class="form-control" id="confirm" name="confirm" placeholder="********">
            <div id="confirm-error" class="p-2">
              <small id="confirm-error-text" class="text-danger"></small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Listo</button>
        </div>
      </div>
    </div>
  </form>
</div>

<script src="js/password-update.js"></script>