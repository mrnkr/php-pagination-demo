<?php

/**
 * Put a script tag in the generated html printing some text
 * in the client console
 * 
 * @param string $text
 */
function console_log($text) {
  echo '<script>console.log(\'' . addslashes($text) . '\')</script>';
}

/**
 * Put a script tag in the generated html printing an error
 * in the client console
 * 
 * @param string $error
 */
function console_error($error) {
  echo '<script>console.error(\'' . addslashes($error) . '\')</script>';
}

?>
