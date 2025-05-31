<?php
header('Content-Type: application/json');
require('../includes/db_connect.php');

$data = json_decode(file_get_contents("php://input"), true);
$product_id = intval($data['product_id']);
$quantity = intval($data['quantity']);
$username = $data['username'] ?? 'admin';

if (!$product_id || !$quantity || !$username) {
    echo json_encode(['status' => 'error', 'message' => 'Missing data']);
    exit;
}

// Get user ID
$userQuery = "SELECT id FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $userQuery);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $user_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit;
}

// Insert or update cart
$insertQuery = "
    INSERT INTO cart (user_id, product_id, quantity)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
";

$stmt = mysqli_prepare($conn, $insertQuery);
mysqli_stmt_bind_param($stmt, "iii", $user_id, $product_id, $quantity);
$success = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($success) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>
