<!doctype html>
<html>
  <head lang="en">
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="theme-color" content="#000000" />
    <title>Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <ul class="list-group list-group-flush">
        <?php
          error_reporting(E_ALL);
          ini_set('display_errors', 1);

          require_once dirname(__FILE__) . '/src/config/database.php';
          require_once dirname(__FILE__) . '/src/models/user.php';

          $db   = new Database();
          $conn = $db->connect();

          $userModel = new User($conn);
          $users = $userModel->find(10);

          foreach($users['data'] as $user) {
            echo '<li class="list-group-item">' . $user['first_name'] . ' ' . $user['last_name'] . '</li>';
          }
        ?>
      </ul>
    </div>
  </body>
</html>
