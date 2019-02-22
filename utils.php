<?php

function console_log($text) {
  echo '<script>console.log(\'' . $text . '\')</script>';
}

function console_error($error) {
  echo '<script>console.error(\'' . $error . '\')</script>';
}

?>
