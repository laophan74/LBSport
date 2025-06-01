<?php
session_start();
header('Content-Type: application/json');
include '../includes/db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$product_id = intval($data['product_id'] ?? 0);
$user_id = $_SESSION['userid'] ?? 0;

if (!$product_id || !$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM reviews WHERE product_id = ? AND user_id = ?");
$stmt->bind_param("ii", $product_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete review.']);
}

$conn->close();
?>
