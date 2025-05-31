<?php
session_start();
header('Content-Type: application/json');
require('../includes/db_connect.php');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$product_id = intval($data['product_id'] ?? 0);
$quantity = intval($data['quantity'] ?? 0);
$userid = $_SESSION['userid'];

if (!$product_id || !$quantity) {
    echo json_encode(['status' => 'error', 'message' => 'Missing product or quantity']);
    exit;
}

$query = "
    INSERT INTO cart (user_id, product_id, quantity)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "iii", $userid, $product_id, $quantity);
$success = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($success) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>
