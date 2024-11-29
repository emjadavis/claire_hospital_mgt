<?php
session_start(); // Start the session

// Destroy the session to log out the user
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session
echo "Logged out successfully";

?>
