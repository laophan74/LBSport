<?php
session_start();
header('Content-Type: application/json');
include '../includes/db_connect.php';

$user_id = $_SESSION['userid'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode(['status' => 'success', 'orders' => $orders]);
$conn->close();
?>
