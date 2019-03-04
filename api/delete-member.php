<?php

/**
 * Endpoint which expects to be requested like api/delete-member.php?id=:id
 * 
 * Simply gets the id from the query params and deletes the user which
 * matches said id.
 */

require_once dirname(__FILE__) . '/../src/utils.php';
require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/member.php';

$done = false;

if (!isset($_GET['id'])) {
  header('Location: ../admin.php?msg=Debes+decirnos+que+usuario+eliminar&msg_type=error', true, 301);
  exit();
}

$db   = new Database();
$conn = $db->connect();

$membe_model = new Member($conn);
$done = $member_model->delete_one($_GET['id']);

header('Location: ../admin.php?msg=' . ($done ? 'Usuario+eliminado+con+exito' : 'Ha+ocurrido+un+error') . '&msg_type=' . ($done ? 'success' : 'error'), true, 301);
exit();

?>