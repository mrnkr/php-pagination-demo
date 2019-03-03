<?php

require_once dirname(__FILE__) . '/../src/utils.php';
require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/member.php';

// Check everything is set

$db   = new Database();
$conn = $db->connect();

$memberModel = new Member($conn);


if ($_POST['updating'] == "yes") {
	$done = $memberModel->updateOne($_POST['id'], $_POST);
	header('Location: ../admin.php?msg=' . ($done ? 'Socio+actualizado+correctamente' : 'Error+actualizando+socio') . '&msg_type=' . ($done ? 'success' : 'error'), true, 301);
	exit();
}


$target_dir = dirname(__FILE__) . '/../bucket/';
$target_file = $target_dir . basename($_FILES['picture']['name']);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES['picture']['tmp_name']);
    if($check !== false) {
				if (file_exists($target_file)) {
    			$uploadOk = 0;
				}

				if ($_FILES['picture']['size'] > 1000000) {
    			$uploadOk = 0;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    			$uploadOk = 0;
				}

        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

if ($uploadOk == 0) {
  header('Location: ../admin.php?msg=Ha+ocurrido+un+error&msg_type=error', true, 301);
	exit();
} else {
    if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
			$_POST['picture_url'] = 'bucket/' . basename($_FILES['picture']['name']);

			$id = $memberModel->insertOne($_POST);
			header('Location: ../admin.php?msg=' . ($id > -1 ? 'Socio+registrado+con+exito' : 'Error+registrando+socio') . '&msg_type=' . ($id > -1 ? 'success' : 'error'), true, 301);
			exit();
    } else {
			header('Location: ../admin.php?msg=Ha+ocurrido+un+error&msg_type=error', true, 301);
			exit();
    }
}

?>
