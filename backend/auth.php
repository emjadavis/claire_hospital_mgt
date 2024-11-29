<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in by verifying the session variable
if (isset($_SESSION['username'])) {
    // If the user is logged in, return a success message
    echo "User is logged in";
} else {
    // If not logged in, return a failure message
    echo "User is not logged in";
}
?>
