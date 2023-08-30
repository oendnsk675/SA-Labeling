<?php 
require 'database/conn.php';


if (isset($_GET['sheet_number'])) {
    $sheet_number = $_GET['sheet_number'];
}else {
    die("Parameter not valid.");
}

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
            WHERE sheet_number = $sheet_number
            GROUP BY
            sheet_number;";

$result = $conn->query($query);

// Mengirimkan data dalam bentuk JSON
header('Content-Type: application/json');
echo json_encode(mysqli_fetch_assoc($result));

?>