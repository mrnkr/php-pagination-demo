<?php

require_once dirname(__FILE__) . '/../src/utils.php';
require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/member.php';

// check everything

$db   = new Database();
$conn = $db->connect();

$memberModel = new Member($conn);
$done = $memberModel->deleteOne($_GET['id']);

header('Location: ../admin.php?msg=' . ($done ? 'Usuario+eliminado+con+exito' : 'Ha+ocurrido+un+error') . '&msg_type=' . ($done ? 'success' : 'error'), true, 301);
exit();

?>
