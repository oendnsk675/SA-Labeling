<?php 
$conn = new mysqli("labeling.data.bimajaya.co.id", "root", "", "bimajaya_dataset");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>