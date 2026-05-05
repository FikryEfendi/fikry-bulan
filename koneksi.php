<?php
$host = "localhost";
$user = "root";       // Default username Laragon
$pass = "";           // Default password Laragon (dikosongkan)
$db   = "db_undangan"; // ⚠️ GANTI dengan nama database yang kamu buat di phpMyAdmin!

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>