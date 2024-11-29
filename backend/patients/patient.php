<?php
include '../db/connect.php';

// Check if the POST request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Sanitize and retrieve form inputs
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $patientDoctor = mysqli_real_escape_string($con, $_POST['patient_doctor']); // Get department name

    //check if the patient already exists
    $checkQuery = "SELECT * FROM patients WHERE email = '$email'";
    $checkResult = mysqli_query($con, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "Patient already exists!";
        exit();
    }

    // Query to get the doctor_id based on the doctor name
    $doctorQuery = "SELECT doctor_id FROM doctors WHERE CONCAT(first_name, ' ',last_name) = '$patientDoctor' LIMIT 1";

    $result = mysqli_query($con, $doctorQuery);
    
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the department ID
        $row = mysqli_fetch_assoc($result);
        $doctorId = $row['doctor_id'];

        // SQL query to insert the doctor data into the database
        $sql = "INSERT INTO patients (first_name, last_name, address, email, date_of_birth, phone, doctor_id) 
                VALUES ('$firstName', '$lastName', '$address', '$email', '$dob', '$phone', '$doctorId')";

        // Execute the query and check if insertion was successful
        if (mysqli_query($con, $sql)) {
            echo "Patient added successfully!";
        } else {
            echo "Error adding doctor: " . mysqli_error($con);
        }
    } else {
        echo "Doctor not found!";
    }
} else {
    echo "Invalid request method.";
}

?>
