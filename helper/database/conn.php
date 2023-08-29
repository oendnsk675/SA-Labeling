<?php 
$conn = new mysqli("localhost", "root", "", "bimajaya_dataset");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>