<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

include '../includes/db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$order_id = $data['order_id'] ?? 0;
$user_id = $_SESSION['userid'];

// Only cancel if status is 'processing'
$stmt = $conn->prepare("UPDATE orders SET status = 'cancelled' WHERE order_id = ? AND user_id = ? AND status = 'processing'");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Order not found or cannot be cancelled']);
}

$conn->close();
