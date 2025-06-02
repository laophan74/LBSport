<?php
session_start();
header('Content-Type: application/json');
include('../includes/db_connect.php');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$userid = $_SESSION['userid'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
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

$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? '';
$id = intval($data['id'] ?? 0);

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
