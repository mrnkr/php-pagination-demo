<?php

session_start();

require_once dirname(__FILE__) . '/../src/utils.php';
require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/activity.php';

if (!isset($_GET['id'])) {
  header('Location: ../dashboard.php?msg=Algo+salio+mal&msg_type=error', true, 301);
  exit();
}

$db   = new Database();
$conn = $db->connect();

$activityModel = new Activity($conn);
$isPartaking = $activityModel->toggleActivityForUser($_GET['id'], $_SESSION['user_id']);

header('Location: ../dashboard.php?msg=Te+' . ($isPartaking ? 'dimos+de+alta' : 'dimos+de+baja') . '+correctamente&msg_type=success', true, 301);
exit();

?>