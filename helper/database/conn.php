<?php 
$conn = new mysqli("localhost", "bimajaya", "", "bimajaya_ds");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>