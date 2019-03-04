<?php

/**
 * Endpoint which destroys the current session and takes the user
 * back to the login screen.
 */

session_start();

session_unset();
session_destroy();

header('Location: ../index.php', true, 301);
exit();

?>