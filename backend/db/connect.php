<?php
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$dbname = 'claire_hospital_mgt';

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $dbname);

if (!$con) {
    die(mysqli_error($conn));
}
?>
