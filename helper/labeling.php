<?php 
require 'database/conn.php';

if (isset($_POST['id']) && isset($_POST['label'])) {
    $id = $_POST['id'];
    $label = $_POST['label'];
}else {
    die("Parameter Invalid.");
}

// Perintah SQL UPDATE
$updateQuery = "UPDATE data SET label = ? , labeled = ? WHERE id = ?";

// Menyiapkan pernyataan SQL dengan menggunakan prepared statement
$stmt = $conn->prepare($updateQuery);

if ($stmt === false) {
    die("Error in preparing the statement.");
}

// Mengikat parameter ke prepared statement
$stmt->bind_param("iii", $label, $label, $id);

$msg = "";
// Melakukan eksekusi pernyataan SQL UPDATE
if ($stmt->execute()) {
    $msg = "Update berhasil.";
} else {
    $msg = "Update gagal: " . $stmt->error;
}

// Menutup pernyataan dan koneksi
$stmt->close();
$conn->close();

// Mengirimkan data dalam bentuk JSON
header('Content-Type: application/json');
echo json_encode($msg);

?>