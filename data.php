<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "your_database");

if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Query to get sums for both Paid and Unpaid per day
$sql = "SELECT 
            payment_date, 
            SUM(CASE WHEN status = 'Paid' THEN amount ELSE 0 END) as paid_total,
            SUM(CASE WHEN status = 'Unpaid' THEN amount ELSE 0 END) as unpaid_total
        FROM payments 
        GROUP BY payment_date 
        ORDER BY payment_date ASC LIMIT 10";

$result = $conn->query($sql);
$data = [];
while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>