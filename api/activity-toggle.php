<?php

/**
 * Endpoint which expects to be requested like api/activity-toggle.php?id=:id
 * 
 * Receives the id for the activity the user wants to toggle.
 * As the name implies, when the user is already registered, they get removed.
 * When they were not registered, they get registered.
 * 
 * This only works with the user which is currently logged in, which is
 * retreived from the active session.
 */

session_start();

require_once dirname(__FILE__) . '/../src/utils.php';
require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/activity.php';

if (!isset($_GET['id'])) {
  header('Location: ../dashboard.php?msg=No+podemos+registrarte+si+no+nos+dices+a+qu%C3%A9+registrarte&msg_type=error', true, 301);
  exit();
}

$db   = new Database();
$conn = $db->connect();

$activity_model = new Activity($conn);
$partaking = $activity_model->toggle_activity_for_user($_GET['id'], $_SESSION['user_id']);

header('Location: ../dashboard.php?msg=Te+' . ($partaking ? 'dimos+de+alta' : 'dimos+de+baja') . '+correctamente&msg_type=success', true, 301);
exit();

?>