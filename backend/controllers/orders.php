<?php
header('Content-Type: application/json');
include('../includes/db_connect.php');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $result = mysqli_query($conn, "SELECT * FROM orders WHERE order_id = $id");
        echo json_encode(mysqli_fetch_assoc($result));
    } else {
        $result = mysqli_query($conn, "SELECT * FROM orders");
        $orders = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
        echo json_encode($orders);
    }
    mysqli_close($conn);
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $data['user_id'], $data['total_amount'], $data['status']);
    $stmt->execute();
    echo json_encode(["order_id" => $stmt->insert_id]);
    mysqli_close($conn);
    exit;
}

if ($method === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);
    $stmt = $conn->prepare("UPDATE orders SET user_id=?, total_amount=?, status=? WHERE order_id=?");
    $stmt->bind_param("idsi", $data['user_id'], $data['total_amount'], $data['status'], $data['order_id']);
    $stmt->execute();
    echo json_encode(["success" => true]);
    mysqli_close($conn);
    exit;
}

if ($method === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $id = intval($data['order_id']);
    mysqli_query($conn, "DELETE FROM orders WHERE order_id = $id");
    echo json_encode(["success" => true]);
    mysqli_close($conn);
    exit;
}
?>
