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
$user_id = $_SESSION['userid'];

$query = "DELETE FROM cart WHERE user_id = ? AND id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $cart_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Item not found or could not be removed']);
}

$stmt->close();
$conn->close();
