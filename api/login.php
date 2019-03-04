<?php

/**
 * Form handler which gets the email and password for the user
 * who is attempting to log in.
 * 
 * Verifies identity and if the credentials resolve to a valid user
 * they will get redirected to the corresponding page. In other case
 * they will be sent back to the login screen with the details
 * corresponding to the error that happened.
 */

require_once dirname(__FILE__) . '/../src/utils.php';
require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/user.php';

if (!isset($_POST['email']) || !isset($_POST['password'])) {
  die();
}

session_start();

$db   = new Database();
$conn = $db->connect();

$user_model = new User($conn);
$user = $user_model->verify($_POST['email'], $_POST['password']);

if (!empty($user)) {
  extract($user);

  $_SESSION['user_id'] = $id;
  $_SESSION['user_name'] = $first_name . ' ' . $last_name;
  $_SESSION['user_email'] = $email;
  $_SESSION['admin'] = $admin;

  if ($user['admin']) {
    header('Location: ../admin.php', true, 301);
  } else {
    header('Location: ../dashboard.php', true, 301);
  }
  exit();
} else {
  header('Location: ../index.php?msg=Credenciales+incorrectas&msg_type=error', true, 301);
  exit();
}

?>