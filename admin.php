<!doctype html>
<?php

session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin'])) {
  header('Location: index.php', true, 301);
  exit();
}

if (!$_SESSION['admin']) {
  header('Location: dashboard.php', true, 301);
  exit();
}

?>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/admin.css">
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
              <a class="nav-link has-pointer" data-toggle="modal" data-target="#memberModal"
                onclick="clearAllFields()">Registrar Socio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link has-pointer" data-toggle="modal" data-target="#passwordModal">Cambiar Contrasena</a>
            </li>
            <li class="nav-item">
              <a class="nav-link has-pointer" href="api/logout.php">Cerrar Sesion</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="jumbotron jumbotron-fluid m-0 p-3">
      <div class="container">
        <div class="d-flex flex-row justify-content-between align-items-center">
          <h5 class="m-0">Socios</h5>

          <small class="ml-auto">Filtrar</small>
          <select class="ml-3">
            <?php

              require_once dirname(__FILE__) . '/src/utils.php';
              require_once dirname(__FILE__) . '/src/config/database.php';
              require_once dirname(__FILE__) . '/src/models/activity.php';

              $output = '<option value="" selected>Actividad</option>';
              $db   = new Database();
              $conn = $db->connect();
              $activityModel = new Activity($conn);
              $allActivities = $activityModel->getAll();

              foreach ($allActivities as $act) {
                $output .= '<option value="' . $act['id'] . '">' . $act['name'] . '</option>';
              }

              echo $output;

            ?>
          </select>
        </div>
      </div>
    </div>

    <div class="container">
      <?php

          if (isset($_GET['msg']) && isset($_GET['msg_type'])) {
            echo '
              <div class="alert alert-' . ($_GET['msg_type'] == 'error' ? 'danger' : 'success')  . ' mt-3" role="alert">
                ' . $_GET['msg']  . '
              </div>
            ';
          }

        ?>

      <ul id="pagination_data" class="list-group list-group-flush">
      </ul>

      <nav class="my-3" aria-label="Page navigation example">
        <ul class="pagination justify-content-center">

          <?php

            if (!isset($_GET['filter'])) {
            $page_len = 10;

            require_once dirname(__FILE__) . '/src/utils.php';
            require_once dirname(__FILE__) . '/src/config/database.php';
            require_once dirname(__FILE__) . '/src/models/member.php';

            $db   = new Database();
            $conn = $db->connect();

            $memberModel = new Member($conn);
            $cnt = $memberModel->count();
            $pages = ceil($cnt / $page_len);

            $output = '
              <li class="page-item has-pointer">
                <a class="page-link" onclick="previous()" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
            ';

            for ($i = 1; $i <= $pages; $i++) {
              $output .= '<li class="page-item has-pointer"><a class="page-link" onclick="loadData(' . $i  . ')">' . $i  . '</a></li>';
            }

            $output .= '
              <li class="page-item has-pointer">
                <a class="page-link" onclick="next(' . $pages  . ')" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            ';

            echo $output;
            }

            ?>

        </ul>
      </nav>
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
  <script src="js/pagination.js"></script>

  <?php include dirname(__FILE__) . '/src/views/register-member.php'; ?>
  <?php include dirname(__FILE__) . '/src/views/change-password.php';  ?>
</body>

</html>