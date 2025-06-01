<?php
session_start();
header('Content-Type: application/json');

include('../includes/db_connect.php');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$userid = $_SESSION['userid'];

$query = "
    SELECT c.id AS cart_id, c.product_id, c.quantity, p.name, p.image, p.price
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $row['price'] = floatval($row['price']);
    $row['quantity'] = intval($row['quantity']);
    $items[] = $row;
    $total += $row['price'] * $row['quantity'];
}

echo json_encode([
    'status' => 'success',
    'items' => $items,
    'total' => $total
]);

$stmt->close();
$conn->close();
