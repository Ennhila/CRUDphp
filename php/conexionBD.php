<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "crud";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $password);
    $conn->select_db($database);
} catch (Exception $e) {
    die("Error de conexion: " . $e->getMessage());
}


?>