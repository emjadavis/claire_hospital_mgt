<?php
 session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include the database connection file
    include '../db/connect.php';  // Ensure this file contains a working MySQLi connection

    // Get the POST data and sanitize inputs
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the username already exists
    $sql = "SELECT * FROM admin WHERE username = ?";
    
    // Prepare the SQL query
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind the username parameter to the SQL query
        mysqli_stmt_bind_param($stmt, "s", $username);
        
        // Execute the statement
        mysqli_stmt_execute($stmt);
        
        // Get the result
        mysqli_stmt_store_result($stmt);
        
        // Check if any rows returned (username exists)
        if (mysqli_stmt_num_rows($stmt) > 0) {
            // If the username already exists, send an error message
            echo 'User already exists';
        } else {
            // If the username doesn't exist, insert the new user
            $sql_insert = "INSERT INTO `admin` (`username`, `password`) VALUES (?, ?)";
            
            // Prepare the INSERT query
            if ($stmt_insert = mysqli_prepare($con, $sql_insert)) {
                // Bind the username and hashed password to the query
                mysqli_stmt_bind_param($stmt_insert, "ss", $username, $hashed_password);
                
                // Execute the INSERT query
                if (mysqli_stmt_execute($stmt_insert)) {
                    $_SESSION['username'] = $username;
                    // If insertion is successful, send a success message
                    echo 'Signup successful';
                } else {
                    // If insertion fails, send an error message
                    echo 'Error: ' . mysqli_error($con);
                }
                
                // Close the INSERT statement
                mysqli_stmt_close($stmt_insert);
            }
        }

        // Close the SELECT statement
        mysqli_stmt_close($stmt);
    } else {
        // If there's an error in preparing the SELECT query
        echo 'Error: ' . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
}
?>
