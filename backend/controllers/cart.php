<?php
session_start();
header('Content-Type: application/json');
include('../includes/db_connect.php');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$userid = $_SESSION['userid'];
$method = $_SERVER['REQUEST_METHOD'];

// GET: Fetch cart items
if ($method === 'GET') {
    $stmt = $conn->prepare("
        SELECT c.id AS cart_id, c.product_id, c.quantity, p.name, p.image, p.price
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
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

    echo json_encode(['status' => 'success', 'items' => $items, 'total' => $total]);
    exit;
}

// Handle POST: Add to cart or modify existing item
$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? '';
$id = intval($data['id'] ?? 0);

// POST: Add to cart (no action specified)
if ($method === 'POST' && !$action) {
    $product_id = intval($data['product_id'] ?? 0);
    $quantity = max(1, intval($data['quantity'] ?? 1));

    // Check if already in cart
    $check = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $check->bind_param("ii", $userid, $product_id);
    $check->execute();
    $existing = $check->get_result()->fetch_assoc();

    if ($existing) {
        $newQty = $existing['quantity'] + $quantity;
        $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $update->bind_param("ii", $newQty, $existing['id']);
        $success = $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $insert->bind_param("iii", $userid, $product_id, $quantity);
        $success = $insert->execute();
    }

    echo json_encode(['status' => $success ? 'success' : 'error', 'message' => $success ? 'Item added to cart' : 'Add failed']);
    exit;
}

// POST: Remove item
if ($action === 'remove') {
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $userid);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Item not found or already removed']);
    }
    exit;
}

// POST: Update quantity
if ($action === 'update') {
    $quantity = max(1, intval($data['quantity'] ?? 1));

    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("iii", $quantity, $id, $userid);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed or no changes']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
