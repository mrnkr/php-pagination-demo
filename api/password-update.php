<?php

/**
 * Form handler which updates the user that is logged in,
 * which it retreives from the current session, to have a
 * different password.
 * 
 * Receives the old password and the new password from the
 * html form and verifies identity in the sql query for the
 * update.
 */

session_start();

require_once dirname(__FILE__) . '/../src/utils.php';
require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/user.php';

if (!isset($_POST['old']) || !isset($_POST['new'])) {
  die();
}

$db   = new Database();
$conn = $db->connect();

$user_model = new User($conn);
$done = $user_model->update_password($_SESSION['user_id'], $_POST['old'], $_POST['new']);

header('Location: ../' . ($_SESSION['admin'] ? 'admin' : 'dashboard') . '.php?msg=' . ($done ? 'Tu+contrase%C3%B1a+ha+sido+actualizada' : 'Ha+ocurrido+un+error') . '&msg_type=' . ($done ? 'success' : 'error'), true, 301);
exit();

?>