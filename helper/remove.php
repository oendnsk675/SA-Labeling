<?php 
require 'database/conn.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
}else {
    die("Parameter not valid.");
}

$query = "DELETE FROM data WHERE id = ?;";

$stmt = $conn->prepare($query);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $msg = "Delete berhasil.";
} else {
    $msg = "Delete gagal: " . $stmt->error;
}

// Menutup pernyataan dan koneksi
$stmt->close();
$conn->close();

// Mengirimkan data dalam bentuk JSON
header('Content-Type: application/json');
echo json_encode($msg);

?>