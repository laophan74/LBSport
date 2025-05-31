<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: login_form.php');
    exit();
}

include '../backend/includes/db_connect.php';

$userid = $_SESSION['userid'];

// Fetch all orders for this user with their items and product info
$sql = "
SELECT 
  o.order_id, o.order_date, o.status, o.total_amount,
  oi.quantity, oi.price,
  p.name AS product_name
FROM orders o
JOIN order_items oi ON o.order_id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE o.user_id = ?
ORDER BY o.order_date DESC, o.order_id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orderId = $row['order_id'];
    if (!isset($orders[$orderId])) {
        $orders[$orderId] = [
            'order_date' => $row['order_date'],
            'status' => $row['status'],
            'total_amount' => $row['total_amount'],
            'items' => []
        ];
    }
    $orders[$orderId]['items'][] = [
        'product_name' => $row['product_name'],
        'quantity' => $row['quantity'],
        'price' => $row['price'],
    ];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Order History - LBSport</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css" />
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php include 'includes/topbar.php'; ?>

        <main class="container flex-grow-1 py-5">
            <h2 class="mb-4">Order History</h2>

            <?php if (empty($orders)): ?>
                <p>You have no orders yet.</p>
            <?php else: ?>
                <?php foreach ($orders as $orderId => $order): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <strong>Order #<?= htmlspecialchars($orderId) ?></strong> 
                            <span class="text-muted">- <?= date('F j, Y, g:i a', strtotime($order['order_date'])) ?></span>
                            <span class="badge bg-info text-dark float-end text-capitalize"><?= htmlspecialchars($order['status']) ?></span>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm mb-3">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                                        <td>$<?= number_format($item['price'], 2) ?></td>
                                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <h5 class="text-end">Total: $<?= number_format($order['total_amount'], 2) ?></h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>

        <?php include 'includes/footer.php'; ?>

        <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
        <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    </body>
</html>
