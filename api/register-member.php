<?php

/**
 * Form handler to either register a new member or modify an
 * already existing one.
 * 
 * To tell the script to update a member set the hidden input
 * named updating to yes and the hidden input named id to the
 * member id - Set the rest normally.
 * 
 * To create a new member set the value of the hidden input
 * updating to no, the script will ignore the id hidden input
 * automagically - Set the rest normally.
 */

require_once dirname(__FILE__) . '/../src/utils.php';
require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/member.php';

/**
 * Run this function to validate all fields required for both
 * updates and creations
 */
function validateBasic() {
  return isset($_POST['first_name']) &&
         isset($_POST['last_name']) &&
         isset($_POST['birthdate']) &&
         isset($_POST['address']) &&
         isset($_POST['phone']) &&
         isset($_POST['email']);
}

/**
 * Run this function to validate all fields required only for
 * insertions
 */
function validateComplete() {
  return validateBasic() &&
         isset($_FILES['picture']) &&
         isset($_POST['password']);
}

$db   = new Database();
$conn = $db->connect();

$member_model = new Member($conn);


if ($_POST['updating'] == 'yes' && validateBasic()) {
  $done = $member_model->update_one($_POST['id'], $_POST);
  header('Location: ../admin.php?msg=' . ($done ? 'Socio+actualizado+correctamente' : 'Error+actualizando+socio') . '&msg_type=' . ($done ? 'success' : 'error'), true, 301);
  exit();
}

if (!validateComplete()) {
  header('Location: ../admin.php?msg=Ha+ocurrido+un+error&msg_type=error', true, 301);
  exit();
}

$target_dir = dirname(__FILE__) . '/../bucket/';
$target_file = $target_dir . basename($_FILES['picture']['name']);
$upload_ok = true;
$image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$error_msg = '';

$check = getimagesize($_FILES['picture']['tmp_name']);
if($check !== false) {
  if (file_exists($target_file)) {
    $error_msg = 'No+se+pudo+subir+el+archivo+porque+ya+existe+otro+que+se+llama+igual';
    $upload_ok = false;
  }

  if ($_FILES['picture']['size'] > 1000000) {
    $error_msg = 'No+se+pudo+subir+el+archivo+porque+pesa+m%C3%A1s+de+1MB';
    $upload_ok = false;
  }

  if($image_file_type != 'jpg' && $image_file_type != 'png' && $image_file_type != 'jpeg') {
    $error_msg = 'No+se+pudo+subir+el+archivo+porque+no+es+ni+jpg+ni+png';
    $upload_ok = false;
  }
} else {
  $error_msg = 'No+se+pudo+subir+el+archivo+porque+no+es+una+imagen';
  $upload_ok = false;
}

if (!$upload_ok) {
  header('Location: ../admin.php?msg=' . $error_msg . '&msg_type=error', true, 301);
  exit();
} else {
  if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
    $_POST['picture_url'] = 'bucket/' . basename($_FILES['picture']['name']);

    $id = $member_model->insert_one($_POST);
    header('Location: ../admin.php?msg=' . ($id > -1 ? 'Socio+registrado+con+exito' : 'Error+registrando+socio') . '&msg_type=' . ($id > -1 ? 'success' : 'error'), true, 301);
    exit();
  } else {
    header('Location: ../admin.php?msg=Ha+ocurrido+un+error&msg_type=error', true, 301);
    exit();
  }
}

?>