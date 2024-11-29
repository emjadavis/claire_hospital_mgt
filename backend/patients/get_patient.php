<?php
include '../db/connect.php';

// Select doctors and their department_id
$sql = "SELECT p.patient_id AS id, 
               p.first_name, 
               p.last_name, 
               p.address,
               p.email, 
               p.date_of_birth, 
               p.phone, 
               p.doctor_id
        FROM patients p";

$result = mysqli_query($con, $sql);

if (!$result) {
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

$patients = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Get department name using doctor_id
    $doctor_id = $row['doctor_id'];
    
    // Query the doctor table to get the doctor name
   $doct_sql = "SELECT CONCAT(first_name, ' ', last_name) AS doctor FROM doctors WHERE doctor_id = $doctor_id";
    $doct_result = mysqli_query($con, $doct_sql);
    if ($doct_result) {
        $doct_row = mysqli_fetch_assoc($doct_result);
        $row['doctor'] = $doct_row['doctor'];  // Add department name to the doctor data
    } else {
        $row['doctor_name'] = 'Unknown';  // If no department found
    }
    
    // Add doctor with department to the array
    $patients[] = $row;
}

echo json_encode($patients); // Send data as JSON
?>
