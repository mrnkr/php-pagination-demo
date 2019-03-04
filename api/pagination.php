<?php

require_once dirname(__FILE__) . '/../src/config/database.php';
require_once dirname(__FILE__) . '/../src/models/activity.php';
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

$members;

if (isset($_GET['activity_id'])) {
  $activityModel = new Activity($conn);
  $members = $activityModel->getUsersForActivity($_GET['activity_id'], $limit, $offset);
} else {
  $memberModel = new Member($conn);
  $members = $memberModel->find($limit, $offset);
}

foreach($members as $m) {
  extract($m);
  $output .= '
    <script>var ' . $first_name . $id  . ' = ' . json_encode($m)  . '</script>
    <li class="list-group-item" data-toggle="modal" data-target="#memberModal" onclick="setAllValues(' . $first_name . $id . ')">
      <div class="d-flex flex-row justify-content-start align-items-center">
        <img class="rounded-circle mr-3 avatar" src="' . $picture_url  . '" alt="Foto de ' . $first_name . ' ' . $last_name  . '" />
        <div class="d-flex flex-column justify-content-around align-items-start">
          <small class="m-0">' . $id  . '</small>
          <h5 class="m-0">' . $last_name . ', ' . $first_name  . '</h5>
          <p class="m-0">' . $email  . '</p>
        </div>
        <a class="ml-auto" href="api/delete-member.php?id=' . $id  . '">Borrar</a>
      </div>
    </li>
  ';
}

echo $output;

?>