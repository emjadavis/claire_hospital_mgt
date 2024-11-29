<?php
include '../db/connect.php';

// Fetch total counts
$totals = [
    'doctors' => 0,
    'patients' => 0,
    'appointments' => 0,
    'departments' => 0,
];
$totalQuery = "
    SELECT 
        (SELECT COUNT(*) FROM doctors) AS doctors,
        (SELECT COUNT(*) FROM patients) AS patients,
        (SELECT COUNT(*) FROM appointments) AS appointments,
        (SELECT COUNT(*) FROM departments) AS departments
";
$totalResult = mysqli_query($con, $totalQuery);
if ($totalResult) {
    $totals = mysqli_fetch_assoc($totalResult);
}

// Fetch 5 most recent patients
$patients = [];
$patientQuery = "SELECT CONCAT(first_name, ' ', last_name) AS name FROM patients ORDER BY patient_id DESC LIMIT 5";
$patientResult = mysqli_query($con, $patientQuery);
while ($row = mysqli_fetch_assoc($patientResult)) {
    $patients[] = $row['name'];
}

// Fetch all doctors
$doctors = [];
$doctorQuery = "SELECT CONCAT(first_name, ' ', last_name) AS name FROM doctors";
$doctorResult = mysqli_query($con, $doctorQuery);
while ($row = mysqli_fetch_assoc($doctorResult)) {
    $doctors[] = $row['name'];
}

// Combine the data and send as JSON
$response = [
    'totals' => $totals,
    'patients' => $patients,
    'doctors' => $doctors,
];

echo json_encode($response);
?>
