<?php
session_start(); // Start session
include '../db/connect.php'; // Include database connection



// Get input data
$input = json_decode(file_get_contents('php://input'), true);
$doctorId = $input['id'];

// Delete doctor by ID
$sql = "DELETE FROM doctors WHERE doctor_id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $doctorId);
if (mysqli_stmt_execute($stmt)) {
    echo "Doctor deleted successfully";
} else {
    echo "Failed to delete doctor";
}
?>
