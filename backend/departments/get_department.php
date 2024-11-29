<?php
include '../db/connect.php';

// Select doctors and their department_id
$sql = "SELECT d.department_id AS id, 
               d.department_name, 
               d.description
        FROM departments d";

$result = mysqli_query($con, $sql);

if (!$result) {
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row;
}
echo json_encode($departments); // Send data as JSON
?>
