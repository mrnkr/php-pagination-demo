<?php

require_once dirname(__FILE__) . '/../src/utils.php';
require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/user.php';

if (!isset($_POST['email']) || !isset($_POST['password'])) {
  die();
}

session_start();

$db   = new Database();
$conn = $db->connect();

$userModel = new User($conn);
$user = $userModel->verify($_POST['email'], $_POST['password']);

if (!empty($user)) {
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['admin'] = $user['admin'];

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