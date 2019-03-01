<?php

require_once dirname(__FILE__) . '/src/utils.php';
require_once dirname(__FILE__) . '/src/config/database.php';
require_once dirname(__FILE__) . '/src/models/user.php';

if (!isset($_POST['email']) || !isset($_POST['password'])) {
  die();
}

session_start();

$db   = new Database();
$conn = $db->connect();

$userModel = new User($conn);
$user = $userModel->verify($_POST['email'], $_POST['password']);

if (!empty($user)) {
  $_SESSION['user'] = $user;
  header('Location: https://192.168.1.10/users_2.php', true, 301);
  exit();
} else {
  echo '<p>Usuario inexistente - <a href="https://192.168.1.10">volver...</a></p>';
}

?>
