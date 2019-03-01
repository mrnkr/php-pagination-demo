<?php

function console_log($text) {
  echo '<script>console.log(\'' . addslashes($text) . '\')</script>';
}

function console_error($error) {
  echo '<script>console.error(\'' . addslashes($error) . '\')</script>';
}

?>
