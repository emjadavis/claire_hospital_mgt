<?php
include '../db/connect.php';

// Select doctors and their department_id
$sql = "SELECT a.appointment_id AS id, 
               a.patient_id, 
               a.doctor_id, 
               a.department_id, 
               a.appointment_date,
               a.appointment_time
        FROM appointments a";

$result = mysqli_query($con, $sql);

if (!$result) {
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

$appointments = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Get name using id
    $patient_id = $row['patient_id'];
    $doctor_id = $row['doctor_id'];
    $department_id = $row['department_id'];
 
    
    // Query the tables to get the names
   $patient_sql = "SELECT CONCAT(first_name, ' ', last_name) AS patient FROM patients WHERE patient_id = $patient_id";
   $doctor_sql = "SELECT CONCAT(first_name, ' ', last_name) AS doctor FROM doctors WHERE doctor_id = $doctor_id";
   $department_sql = "SELECT department_name AS departmentName FROM departments WHERE department_id = $department_id";

    $patient_result = mysqli_query($con, $patient_sql);
    $doctor_result = mysqli_query($con, $doctor_sql);
    $department_result = mysqli_query($con, $department_sql);

   if ($patient_result) {
    $patient_row = mysqli_fetch_assoc($patient_result);
    $row['patient'] = $patient_row['patient'];
    } else {
    $row['patient'] = 'Unknown';
    }

    if ($doctor_result) {
        $doctor_row = mysqli_fetch_assoc($doctor_result);
        $row['doctor'] = $doctor_row['doctor'];  
    } else {
        $row['doctor'] = 'Unknown'; 
    }

    if ($department_result) {
        $department_row = mysqli_fetch_assoc($department_result);
        $row['departmentName'] = $department_row['departmentName'];  
    } else {
        $row['department'] = 'Unknown';  
    }
    
    // Add doctor with department to the array
    $appointments[] = $row;
}

echo json_encode($appointments); // Send data as JSON
?>
