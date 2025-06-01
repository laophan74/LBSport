<?php
session_start();
header('Content-Type: application/json');
include '../includes/db_connect.php';

$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['userid'];

$stmt = $conn->prepare("
    SELECT p.name, p.image, oi.product_id, oi.quantity, oi.price,
        r.rating, r.comment
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    LEFT JOIN reviews r ON r.product_id = oi.product_id AND r.user_id = ?
    WHERE oi.order_id = ?
");
$stmt->bind_param("ii", $user_id, $order_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = [
        'name' => $row['name'],
        'image' => $row['image'],
        'product_id' => $row['product_id'],
        'quantity' => $row['quantity'],
        'price' => $row['price'],
        'review' => $row['rating'] !== null ? ['rating' => $row['rating'], 'comment' => $row['comment']] : null
    ];
}

echo json_encode(['status' => 'success', 'items' => $items]);
$conn->close();
?>
