<?php
session_start(); // Start the session
session_destroy(); // Destroy the session to log the user out
header('Location: index.php'); // Redirect to the login page after logout
exit;
?>
