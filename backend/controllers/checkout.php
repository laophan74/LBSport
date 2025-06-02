<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

include '../includes/db_connect.php';

$user_id = $_SESSION['userid'];
$payment_method = $_POST['payment_method'] ?? '';
$address = trim($_POST['address'] ?? '');
$contact = trim($_POST['contact_number'] ?? '');

// Validate inputs
if (!$payment_method || !$address || !$contact) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

// Get cart items
$stmt = $conn->prepare("
    SELECT c.product_id, c.quantity, p.price 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if (empty($cart_items)) {
    echo json_encode(['status' => 'error', 'message' => 'Your cart is empty.']);
    exit;
}

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['quantity'] * $item['price'];
}

// Insert order
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')");
$stmt->bind_param("id", $user_id, $total);
if (!$stmt->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to place order.']);
    exit;
}
$order_id = $stmt->insert_id;
$stmt->close();

// Insert order items and update stock
$stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
$stock_stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");

foreach ($cart_items as $item) {
    $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
    $stmt->execute();

    $stock_stmt->bind_param("ii", $item['quantity'], $item['product_id']);
    if (!$stock_stmt->execute()) {
        error_log("Stock update failed for product_id {$item['product_id']}: " . $stock_stmt->error);
    }
}

$stmt->close();
$stock_stmt->close();

// Clear cart
$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

$conn->close();

echo json_encode(['status' => 'success', 'message' => 'Order placed successfully.']);
