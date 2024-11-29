<?php
 session_start();

// Include the database connection file
include '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query
    $sql = "SELECT admin_id, username, password FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt === false) {
        // Handle query preparation failure
        echo "Error in query preparation.";
        exit;
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the user exists
    if ($result) {
        $row = mysqli_fetch_assoc($result); // Get the row

        if ($row) {
            $storedHash = $row['password'];

            // Verify the password
            if (password_verify($password, $storedHash)) {
               
                // Password is correct, start session and store user info
                $_SESSION['user_id'] = $row['admin_id']; // Store the user ID in the session
                $_SESSION['username'] = $row['username']; // Store the username in the session
                
                // Send success response
                echo "Login successful!";
            } else {
                // Invalid password
                echo "Invalid password.";
            }
        } else {
            // User does not exist
            echo "User does not exist!";
        }
    } else {
        // Query failed
        echo "Database query failed.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
  mysqli_close($con);
?>
