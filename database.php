<?php
$host = 'shuttle-db-instance.cdvujfenzipi.us-east-1.rds.amazonaws.com';
$user = 'admin';
$password = 'iloveaws';
$dbname = 'shuttle_db';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
