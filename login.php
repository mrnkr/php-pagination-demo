<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__FILE__) . '/src/utils.php';
require_once dirname(__FILE__) . '/src/config/database.php';
require_once dirname(__FILE__) . '/src/models/user.php';

if (!isset($_POST['email']) || !isset($_POST['password'])) {
  die();
}

// session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$db   = new Database();
$conn = $db->connect();

$userModel = new User($conn);
$user = $userModel->verify($email, $password);

console_log(json_encode($user));

if (!empty($user)) {
  // $_SESSION['user'] = $user;
  // echo '<p>User logged in as: '.$_SESSION['user']->$first_name.' '.$_SESSION['user']->$last_name.'</p>';
  echo '<p>Logged in</p>';
} else {
  echo '<p>No user</p>';
}

?>
