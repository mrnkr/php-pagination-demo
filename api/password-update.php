<?php

session_start();

require_once dirname(__FILE__) . '/../src/utils.php';
require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/user.php';

if (!isset($_POST['old']) || !isset($_POST['new'])) {
	die();
}

$db   = new Database();
$conn = $db->connect();

$userModel = new User($conn);
$done = $userModel->updatePassword($_SESSION['user_id'], $_POST['old'], $_POST['new']);

header('Location: ../dashboard.php?msg=' . ($done ? 'Tu+contrasena+ha+sido+actualizada' : 'Ha+ocurrido+un+error') . '&msg_type=' . ($done ? 'success' : 'error'), true, 301);
exit();

?>
