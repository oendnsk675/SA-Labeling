<?php 
require 'database/conn.php';


$query = "SELECT
            sheet_number,
            COUNT(*) AS total_data_in_group,
            SUM(CASE WHEN labeled IS NULL THEN 1 ELSE 0 END) AS unlabeled_data_count
            FROM
            (
                SELECT
                    FLOOR((id - 500) / 500) + 2 AS sheet_number,
                    labeled
                FROM
                    data
            ) subquery
            GROUP BY
            sheet_number;";

$result = $conn->query($query);

// Inisialisasi array untuk menyimpan hasil
$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Menambahkan setiap baris hasil ke dalam array
        $data[] = $row;
    }
}

// Mengirimkan data dalam bentuk JSON
header('Content-Type: application/json');
echo json_encode($data);

?>