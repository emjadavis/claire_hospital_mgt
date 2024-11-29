<?php
include '../db/connect.php';

// Check if the POST request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Sanitize and retrieve form inputs
    $department_name = mysqli_real_escape_string($con, $_POST['department_name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    //check if the doctor already exists
    $checkQuery = "SELECT * FROM departments WHERE department_name = '$department_name'";
    $checkResult = mysqli_query($con, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "Department already exists!";
        exit();
    }

        
        $sql = "INSERT INTO departments (department_name, description) 
                VALUES ('$department_name', '$description')";

        // Execute the query and check if insertion was successful
        if (mysqli_query($con, $sql)) {
            echo "Department added successfully!";
        } else {
            echo "Error adding department: " . mysqli_error($con);
        }
    
} else {
    echo "Invalid request method.";
}

?>
