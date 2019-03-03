<!doctype html>
<?php session_start(); if (!isset($_SESSION['user_id'])) { header('Location: index.php', true, 301); exit(); }  ?>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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

					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    				<span class="navbar-toggler-icon"></span>
  				</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
        				<a class="nav-link has-pointer" data-toggle="modal" data-target="#exampleModal">Cambiar Contrasena</a>
      				</li>
							<li class="nav-item">
        				<a class="nav-link has-pointer" href="api/logout.php">Cerrar Sesion</a>
      				</li>
						</ul>
					</div>
				</div>
    	</nav>

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

				<div class="d-flex flex-row flex-wrap">
					<?php

          	require_once dirname(__FILE__) . '/src/utils.php';
          	require_once dirname(__FILE__) . '/src/config/database.php';
          	require_once dirname(__FILE__) . '/src/models/activity.php';

          	if (!isset($_SESSION['user_id'])) {
            	exit('Not logged in');
          	}

          	$output = '';

  	        $db   = new Database();
 	        	$conn = $db->connect();

          	$activityModel = new Activity($conn);
          	$allActivities = $activityModel->getAll();
          	$myActivities  = $activityModel->forUser($_SESSION['user_id']);

          	foreach ($allActivities as $act) {
            	extract($act);

            	$output .= '
              	<div class="col-md-6">
                	<div class="card my-2">
                  	<img src="' . $act['picture_url']  . '" class="card-img-top" alt="' . $act['name'] . '">
                  	<div class="card-body">
                    	<h5 class="card-title">' . $act['name']  . '</h5>
                    	<a href="api/activity_toggle.php?id=' . $act['id']  . '" class="btn btn-primary">' . ($myActivities[$act['name']] ? 'Darse de baja' : 'Darse de alta')  . '</a>
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

		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		<script src="js/password-update.js"></script>
  </body>
</html>
