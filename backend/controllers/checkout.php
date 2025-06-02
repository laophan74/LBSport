<?php
// Start session to access user info
session_start();
header('Content-Type: application/json');

// Show all errors (for development - remove later)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}


include '../includes/db_connect.php';

$user_id = $_SESSION['userid'];
$payment_method = $_POST['payment_method'] ?? '';
$address = trim($_POST['address'] ?? '');
$contact = trim($_POST['contact_number'] ?? '');

// Check if all fields are filled
if (!$payment_method || !$address || !$contact) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

// Get all cart items of the user
$stmt = $conn->prepare("SELECT c.product_id, c.quantity, p.price 
                        FROM cart c 
                        JOIN products p ON c.product_id = p.id 
                        WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();


if (empty($cart_items)) {
    echo json_encode(['status' => 'error', 'message' => 'Your cart is empty.']);
    exit;
}

// Calculate total price
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['quantity'] * $item['price'];
}

// Create order entry in database
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')");
$stmt->bind_param("id", $user_id, $total);
if (!$stmt->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to place order.']);
    $stmt->close();
    $conn->close();
    exit;
}
$order_id = $stmt->insert_id;
$stmt->close();

// Add order items and update stock
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

// Clear the user's cart after placing order
$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

$conn->close();
echo json_encode(['status' => 'success', 'message' => 'Order placed successfully.']);
