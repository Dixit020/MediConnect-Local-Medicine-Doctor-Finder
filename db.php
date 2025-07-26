<?php
$host = "localhost";
$user = "root"; // Change if your DB user is different
$password = ""; // Add your DB password
$database = "mediconnect"; // Change if your DB name is different

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
