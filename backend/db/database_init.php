<?php
// MySQL connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "claire_hospital_mgt";

// Create a connection
$conn = new mysqli($servername, $username, $password);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


   $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create tables without primary keys or AUTO_INCREMENT for IDs
$tableQueries = [
    "CREATE TABLE IF NOT EXISTS admin (
        admin_id INT NOT NULL,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS departments (
        department_id INT NOT NULL,
        department_name VARCHAR(100) NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS doctors (
        doctor_id INT NOT NULL,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        date_of_birth DATE,
        phone VARCHAR(15),
        department_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS patients (
        patient_id INT NOT NULL,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        address TEXT NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        date_of_birth DATE,
        phone VARCHAR(15),
        doctor_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS appointments (
        appointment_id INT NOT NULL,
        patient_id INT NOT NULL,
        doctor_id INT NOT NULL,
        department_id INT NOT NULL,
        appointment_date DATE NOT NULL,
        appointment_time TIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

// Execute table creation queries
foreach ($tableQueries as $query) {
    if ($conn->query($query) === TRUE) {
        echo "Table created successfully.<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

// Add Primary Keys with AUTO_INCREMENT using ALTER TABLE
$primaryKeyQueries = [
    "ALTER TABLE admin MODIFY admin_id INT AUTO_INCREMENT PRIMARY KEY",
    "ALTER TABLE departments MODIFY department_id INT AUTO_INCREMENT PRIMARY KEY",
    "ALTER TABLE doctors MODIFY doctor_id INT AUTO_INCREMENT PRIMARY KEY",
    "ALTER TABLE patients MODIFY patient_id INT AUTO_INCREMENT PRIMARY KEY",
    "ALTER TABLE appointments MODIFY appointment_id INT AUTO_INCREMENT PRIMARY KEY"
];

// Execute primary key constraints
foreach ($primaryKeyQueries as $query) {
    if ($conn->query($query) === TRUE) {
        echo "Primary key with AUTO_INCREMENT added successfully.<br>";
    } else {
        echo "Error adding primary key: " . $conn->error . "<br>";
    }
}

// Add Foreign Keys using ALTER TABLE
$foreignKeyQueries = [
    "ALTER TABLE doctors ADD CONSTRAINT fk_doctors_department FOREIGN KEY (department_id) REFERENCES departments(department_id) ON DELETE SET NULL",
    "ALTER TABLE patients ADD CONSTRAINT fk_patients_doctor FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE SET NULL ON UPDATE CASCADE",
    "ALTER TABLE appointments ADD CONSTRAINT fk_appointments_patient FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE ",
    "ALTER TABLE appointments ADD CONSTRAINT fk_appointments_doctor FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE ",
    "ALTER TABLE appointments ADD CONSTRAINT fk_appointments_department FOREIGN KEY (department_id) REFERENCES departments(department_id) ON DELETE CASCADE "
];

// Execute foreign key constraints
foreach ($foreignKeyQueries as $query) {
    if ($conn->query($query) === TRUE) {
        echo "Foreign key added successfully.<br>";
    } else {
        echo "Error adding foreign key: " . $conn->error . "<br>";
    }
}

// Close the connection
$conn->close();

?>