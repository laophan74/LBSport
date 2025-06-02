<?php
session_start();
header('Content-Type: application/json');
include('../includes/db_connect.php');

$method = $_SERVER['REQUEST_METHOD'];

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['userid'];
$role = $_SESSION['role'] ?? 'customer';
$is_admin = ($role === 'admin');

// ========== GET ==========
if ($method === 'GET') {
    // Admin gets all orders (for admin dashboard)
    if ($is_admin && !isset($_GET['order_id'])) {
        $stmt = $conn->prepare("SELECT * FROM orders ORDER BY order_date DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        echo json_encode($orders);
        $stmt->close();
        $conn->close();
        exit;
    }

    // Get order detail (user)
    if (isset($_GET['order_id'])) {
        $order_id = intval($_GET['order_id']);

        $stmt = $conn->prepare("SELECT o.*, oi.product_id, oi.quantity, oi.price, p.name, p.image,
                                       r.rating, r.comment
                                  FROM orders o
                             LEFT JOIN order_items oi ON o.order_id = oi.order_id
                             LEFT JOIN products p ON oi.product_id = p.id
                             LEFT JOIN reviews r ON oi.product_id = r.product_id AND r.user_id = ?
                                 WHERE o.order_id = ? AND o.user_id = ?");
        $stmt->bind_param("iii", $user_id, $order_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = [
                'product_id' => $row['product_id'],
                'name' => $row['name'],
                'image' => $row['image'],
                'price' => (float)$row['price'],
                'quantity' => (int)$row['quantity'],
                'review' => $row['rating'] !== null ? [
                    'rating' => (int)$row['rating'],
                    'comment' => $row['comment']
                ] : null
            ];
        }

        echo json_encode(['status' => 'success', 'items' => $items]);
        $stmt->close();
        $conn->close();
        exit;
    }

    // Regular user gets their own orders
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $row['can_cancel'] = (strtolower($row['status']) === 'processing');
        $orders[] = $row;
    }

    echo json_encode(['status' => 'success', 'orders' => $orders]);
    $stmt->close();
    $conn->close();
    exit;
}

// ========== POST ==========
if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $data['user_id'], $data['total_amount'], $data['status']);
    $stmt->execute();
    echo json_encode(["order_id" => $stmt->insert_id]);
    $stmt->close();
    $conn->close();
    exit;
}

// ========== PUT ==========
if ($method === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);
    $stmt = $conn->prepare("UPDATE orders SET user_id=?, total_amount=?, status=? WHERE order_id=?");
    $stmt->bind_param("idsi", $data['user_id'], $data['total_amount'], $data['status'], $data['order_id']);
    $stmt->execute();
    echo json_encode(["success" => true]);
    $stmt->close();
    $conn->close();
    exit;
}

// ========== DELETE ==========
if ($method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $order_id = $data['order_id'] ?? 0;

    if ($is_admin) {
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        echo json_encode(['status' => 'success']);
        $stmt->close();
        $conn->close();
        exit;
    }

    // Regular user can only cancel 'processing' orders
    $stmt = $conn->prepare("UPDATE orders SET status = 'cancelled' WHERE order_id = ? AND user_id = ? AND LOWER(status) = 'processing'");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Order not found or cannot be cancelled']);
    }
    $stmt->close();
    $conn->close();
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Unsupported request']);
$conn->close();
exit;
