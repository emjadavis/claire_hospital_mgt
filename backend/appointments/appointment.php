<?php
include '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = mysqli_real_escape_string($con, $_POST['appointment_id']);
    $patientName = mysqli_real_escape_string($con, $_POST['patientName']);
    $doctorName = mysqli_real_escape_string($con, $_POST['doctorName']);
    $departmentName = mysqli_real_escape_string($con, $_POST['departmentName']);
    $appointment_date = mysqli_real_escape_string($con, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($con, $_POST['appointment_time']);

    $checkQuery = "SELECT * FROM appointments WHERE appointment_id = '$appointment_id'";
    $checkResult = mysqli_query($con, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "Appointment already exists!";
        exit();
    }

    $patientQuery = "SELECT patient_id FROM patients WHERE CONCAT(first_name, ' ', last_name) = '$patientName' LIMIT 1";
    $doctorQuery = "SELECT doctor_id FROM doctors WHERE CONCAT(first_name, ' ', last_name) = '$doctorName' LIMIT 1";
    $departmentQuery = "SELECT department_id FROM departments WHERE department_name = '$departmentName' LIMIT 1";

    $result = mysqli_query($con, $patientQuery);
    $result1 = mysqli_query($con, $doctorQuery);
    $result2 = mysqli_query($con, $departmentQuery);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo "Patient not found!";
    } elseif (!$result1 || mysqli_num_rows($result1) == 0) {
        echo "Doctor not found!";
    } elseif (!$result2 || mysqli_num_rows($result2) == 0) {
        echo "Department not found!";
    } else {
        $patientId = mysqli_fetch_assoc($result)['patient_id'];
        $doctorId = mysqli_fetch_assoc($result1)['doctor_id'];
        $departmentId = mysqli_fetch_assoc($result2)['department_id'];

        $sql = "INSERT INTO appointments (appointment_id, patient_id, doctor_id, department_id, appointment_date, appointment_time) 
                VALUES ('$appointment_id', '$patientId', '$doctorId', '$departmentId', '$appointment_date', '$appointment_time')";

        if (mysqli_query($con, $sql)) {
            echo "Appointment added successfully!";
        } else {
            echo "Error adding appointment: " . mysqli_error($con);
        }
    }
} else {
    echo "Invalid request method.";
}
