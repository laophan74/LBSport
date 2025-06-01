<?php
session_start();
header('Content-Type: application/json');
include('../includes/db_connect.php');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$cart_id = intval($data['id']);
$quantity = intval($data['quantity']);
$user_id = $_SESSION['userid'];

if ($quantity < 1) {
    echo json_encode(['status' => 'error', 'message' => 'Quantity must be at least 1']);
    exit;
}

$query = "UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $quantity, $cart_id, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Update failed or no change']);
}

$stmt->close();
$conn->close();
