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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
							<li class="nav-item">
                <a class="nav-link has-pointer" data-toggle="modal" data-target="#memberModal" onclick="clearAllFields()">Registrar Socio</a>
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

		<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
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

		<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form id="my-form" action="api/password-update.php" method="post">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Cambiar contrasena</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="old">Contrasena Actual</label>
                  <input type="password" class="form-control" id="old" name="old" placeholder="********">
                  <div id="old-error" class="p-2">
                    <small id="old-error-text" class="text-danger"></small>
                  </div>
                </div>

                <div class="form-group">
                  <label for="new">Nueva Contrasena</label>
                  <input type="password" class="form-control" id="new" name="new" placeholder="********">
                  <div id="new-error" class="p-2">
                    <small id="new-error-text" class="text-danger"></small>
                  </div>
                </div>

                <div class="form-group">
                  <label for="old">Confirmar Nueva Contrasena</label>
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

		<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="js/pagination.js"></script>
		<script src="js/password-update.js"></script>
		<script src="js/register-member.js"></script>
	</body>
</html>
