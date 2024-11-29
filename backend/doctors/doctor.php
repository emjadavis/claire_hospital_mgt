<?php
include '../db/connect.php';

// Check if the POST request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Sanitize and retrieve form inputs
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $department = mysqli_real_escape_string($con, $_POST['department']); // Get department name

    //check if the doctor already exists
    $checkQuery = "SELECT * FROM doctors WHERE email = '$email'";
    $checkResult = mysqli_query($con, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "Doctor already exists!";
        exit();
    }

    // Query to get the department_id based on the department name
    $departmentQuery = "SELECT department_id FROM departments WHERE department_name = '$department' LIMIT 1";
    $result = mysqli_query($con, $departmentQuery);
    
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the department ID
        $row = mysqli_fetch_assoc($result);
        $departmentId = $row['department_id'];

        // SQL query to insert the doctor data into the database
        $sql = "INSERT INTO doctors (first_name, last_name, email, date_of_birth, phone, department_id) 
                VALUES ('$firstName', '$lastName', '$email', '$dob', '$phone', '$departmentId')";

        // Execute the query and check if insertion was successful
        if (mysqli_query($con, $sql)) {
            echo "Doctor added successfully!";
        } else {
            echo "Error adding doctor: " . mysqli_error($con);
        }
    } else {
        echo "Department not found!";
    }
} else {
    echo "Invalid request method.";
}

?>
