<?php
session_start(); // Start session
include '../db/connect.php'; // Include database connection


// Get input data
$input = json_decode(file_get_contents('php://input'), true);
$appointmentId = $input['id'];

// Delete doctor by ID
$sql = "DELETE FROM appointments WHERE appointment_id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $appointmentId);
if (mysqli_stmt_execute($stmt)) {
    echo "Appointment deleted successfully";
} else {
    echo "Failed to delete appointment";
}
?>
