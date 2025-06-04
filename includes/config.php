<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistem_gaji";

$conn = new mysqli($host, $user, $pass, $db);
// Cek koneksi
if ($conn->connect_error) {
    die("<div class='alert alert-danger'>Koneksi database gagal: " 
        . $conn->connect_error . "</div>");
}
?>