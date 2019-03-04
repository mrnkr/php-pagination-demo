<!doctype html>
<?php

/**
 * If the session shows there is a user already logged in
 * redirect to where they should be
 */

session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['admin'])) {
  header('Location: ' . ($_SESSION['admin'] ? 'admin.php' : 'dashboard.php'), true, 301);
  exit();
}

?>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/index.css">
  <title>Club Social y Deportivo Random</title>
</head>

<body>
  <div class="container">
    <form id="my-form" class="d-flex flex-column justify-content-start align-items-stretch my-5" action="api/login.php"
      method="post">
      <img class="logo mb-3" src="images/Random.jpg" alt="Logo del club" />

      <?php

        /**
         * If the user got redirected after an operation and the feedback was provided like
         * index.php?msg=some+message&msg_typesuccess+or+error
         * then show said message
         */

        if (isset($_GET['msg']) && isset($_GET['msg_type'])) {
          echo '
            <div class="alert alert-' . ($_GET['msg_type'] == 'error' ? 'danger' : 'success')  . ' mt-3" role="alert">
              ' . $_GET['msg']  . '
            </div>
          ';
        }

      ?>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="Ingresa tu email">
        <div id="email-error" class="p-2">
          <small id="email-error-text"></small>
        </div>
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="********">
        <div id="password-error" class="p-2">
          <small id="password-error-text" class="text-danger"></small>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>
  <script src="js/pre-login.js"></script>
</body>

</html>