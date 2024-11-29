<?php
session_start(); // Start session
include '../db/connect.php'; // Include database connection

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id'])) {
    $departmentId = $input['id'];

    // Debugging: Log received data
    error_log("Received department ID: " . $departmentId);

    // Delete department by ID
    $sql = "DELETE FROM departments WHERE department_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $departmentId);
        if (mysqli_stmt_execute($stmt)) {
            echo "Department deleted successfully";
        } else {
            // Log database error for debugging
            error_log("Database error: " . mysqli_error($con));
            echo "Failed to delete department";
        }
    } else {
        // Log statement preparation error
        error_log("Failed to prepare statement: " . mysqli_error($con));
        echo "Failed to delete department";
    }
} else {
    // Handle missing or invalid ID
    error_log("Invalid input: No ID provided");
    echo "Invalid input";
}
?>
