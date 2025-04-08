<?php
$server = "localhost";  // Sesuaikan dengan konfigurasi server
$username = "root";       // Sesuaikan dengan username database
$password = "";           // Sesuaikan dengan password database
$database_name = "crm_donat"; // Sesuaikan dengan nama database

$mysqli = new mysqli($server, $username, $password, $database_name);

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
?>
