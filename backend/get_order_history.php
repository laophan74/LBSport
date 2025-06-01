<?php
session_start();
if (!isset($_SESSION['userid'])) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

include '../includes/db_connect.php';
$user_id = $_SESSION['userid'];

$sql = "SELECT id, total, order_date FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
