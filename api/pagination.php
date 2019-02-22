<?php

require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/user.php';

$page = 1;
$page_len = 10;

if (isset($_GET['page'])) {
  $page = $_GET['page'];
}

$limit  = $page * $page_len;
$offset = ($page - 1) * $page_len;
$output = '';

$db   = new Database();
$conn = $db->connect();

$userModel = new User($conn);
$users = $userModel->find($limit, $offset);

foreach($users['data'] as $user) {
  $output .= '<li class="list-group-item">' . $user['last_name'] . ', ' . $user['first_name'] . '</li>';
}

echo $output;

?>
