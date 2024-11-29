<?php
include '../db/connect.php';

// Select doctors and their department_id
$sql = "SELECT d.doctor_id AS id, 
               d.first_name, 
               d.last_name, 
               d.email, 
               d.date_of_birth, 
               d.phone, 
               d.department_id
        FROM doctors d";

$result = mysqli_query($con, $sql);

if (!$result) {
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

// Check if there are any doctors in the result
if (mysqli_num_rows($result) === 0) {
    echo json_encode(['message' => 'No doctors found']); // Respond with no data
    exit;
}

$doctors = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Get department name using department_id
    $department_id = $row['department_id'];

    // Check if department_id is valid (not null or empty)
    if (!empty($department_id)) {
        // Use a prepared statement to avoid syntax issues and potential SQL injection
        $dept_sql = "SELECT department_name FROM departments WHERE department_id = ?";
        $stmt = mysqli_prepare($con, $dept_sql);
        mysqli_stmt_bind_param($stmt, "i", $department_id);
        mysqli_stmt_execute($stmt);
        $dept_result = mysqli_stmt_get_result($stmt);

        if ($dept_result && mysqli_num_rows($dept_result) > 0) {
            $dept_row = mysqli_fetch_assoc($dept_result);
            $row['department'] = $dept_row['department_name'];  // Add department name to the doctor data
        } else {
            $row['department'] = 'Unknown';  // If no department found
        }
    } else {
        $row['department'] = 'No Department';  // If doctor has no department assigned
    }

    // Add doctor with department to the array
    $doctors[] = $row;
}

// Send data as JSON
echo json_encode($doctors);
?>
