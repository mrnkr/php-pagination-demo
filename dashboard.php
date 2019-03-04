<!doctype html>
<?php

  /**
   * If the session shows there is no user logged in send them back
   * to the login page. If instead it shows the user which is logged
   * in is an admin send them to their intended dashboard.
   */

  session_start();

  if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin'])) {
    header('Location: index.php', true, 301);
    exit();
  }

  if ($_SESSION['admin']) {
    header('Location: admin.php', true, 301);
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
  <link rel="stylesheet" href="css/dashboard.css">
  <title>Club Social y Deportivo Random</title>
</head>

<body>
  <div class="container-fluid m-0 p-0">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="#">
          Club Social y Deportivo Random
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link has-pointer" data-toggle="modal" data-target="#passwordModal">Cambiar Contraseña</a>
            </li>
            <li class="nav-item">
              <a class="nav-link has-pointer" href="api/logout.php">Cerrar Sesión</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <?php include dirname(__FILE__) . '/src/views/hello.php'; ?>

    <div class="container">
      <?php

        /**
         * If the user got redirected after an operation and the feedback was provided like
         * dashboard.php?msg=some+message&msg_typesuccess+or+error
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

      <div class="d-flex flex-row flex-wrap">
        <?php

          /**
           * Get all activities and put them as cards for the user to be able
           * to see them and both register or unregister from them
           */

          require_once dirname(__FILE__) . '/src/utils.php';
          require_once dirname(__FILE__) . '/src/config/database.php';
          require_once dirname(__FILE__) . '/src/models/activity.php';

          $output = '';

          $db   = new Database();
          $conn = $db->connect();

          $activity_model = new Activity($conn);
          $activities = $activity_model->get_all();
          $my_activities  = $activity_model->for_user($_SESSION['user_id']);

          foreach ($activities as $act) {
            extract($act);

            $output .= '
              <div class="col-md-6">
                <div class="card my-2">
                  <img src="' . $act['picture_url']  . '" class="card-img-top" alt="' . $act['name'] . '">
                  <div class="card-body">
                    <h5 class="card-title">' . $act['name']  . '</h5>
                    <a href="api/activity-toggle.php?id=' . $act['id']  . '" class="btn btn-primary">' . ($my_activities[$act['name']] ? 'Darse de baja' : 'Darse de alta')  . '</a>
                  </div>
                </div>
              </div>
            ';
          }

          echo $output;

        ?>
      </div>
    </div>
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

  <?php include dirname(__FILE__) . '/src/views/change-password.php'; ?>
</body>

</html>