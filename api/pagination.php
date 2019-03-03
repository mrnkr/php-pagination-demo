<?php

require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/member.php';

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

$memberModel = new Member($conn);
$members = $memberModel->find($limit, $offset);

foreach($members as $m) {
	extract($m);
  $output .= '
		<li class="list-group-item">
			<div class="d-flex flex-row justify-content-start align-items-center">
				<img class="rounded-circle mr-3 avatar" src="' . $picture_url  . '" alt="Foto de ' . $first_name . ' ' . $last_name  . '" />
				<div class="d-flex flex-column justify-content-around align-items-start">
					<small class="m-0">' . $id  . '</small>
					<h5 class="m-0">' . $last_name . ', ' . $first_name  . '</h5>
					<p class="m-0">' . $email  . '</p>
				</div>
			</div>
		</li>
	';
}

echo $output;

?>
