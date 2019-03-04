<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel"
  aria-hidden="true">
  <form id="member-form" action="api/register-member.php" method="post" enctype="multipart/form-data">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="memberModalLabel">Registro de socio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="first_name">Nombre</label>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="John">
            <div id="first_name-error" class="p-2">
              <small id="first_name-error-text" class="text-danger"></small>
            </div>
          </div>

          <div class="form-group">
            <label for="last_name">Apellido</label>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Doe">
            <div id="last_name-error" class="p-2">
              <small id="last_name-error-text" class="text-danger"></small>
            </div>
          </div>

          <div class="form-group" id="picture-cont">
            <label for="picture">Seleccionar foto</label>
            <input type="file" class="form-control-file" id="picture" name="picture">
            <div id="picture-error" class="p-2">
              <small id="picture-error-text" class="text-danger"></small>
            </div>
          </div>

          <div class="form-group">
            <label for="birthdate">Fecha de nacimiento</label>
            <input type="text" class="form-control" id="birthdate" name="birthdate" placeholder="1960-01-01">
            <div id="birthdate-error" class="p-2">
              <small id="birthdate-error-text" class="text-danger"></small>
            </div>
          </div>

          <div class="form-group">
            <label for="address">Domicilio</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Avenida de la Merluza 123">
            <div id="address-error" class="p-2">
              <small id="address-error-text" class="text-danger"></small>
            </div>
          </div>

          <div class="form-group">
            <label for="phone">Telefono</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="099 123 456">
            <div id="phone-error" class="p-2">
              <small id="phone-error-text" class="text-danger"></small>
            </div>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="john@doe.com">
            <div id="email-error" class="p-2">
              <small id="email-error-text" class="text-danger"></small>
            </div>
          </div>

          <div class="form-group" id="password-cont">
            <label for="password">Contrasena</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="********">
            <div id="password-error" class="p-2">
              <small id="password-error-text" class="text-danger"></small>
            </div>
          </div>

          <input type="hidden" id="updating" name="updating" value="no">
          <input type="hidden" id="id" name="id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Listo</button>
        </div>
      </div>
    </div>
  </form>
</div>

<script src="js/register-member.js"></script>