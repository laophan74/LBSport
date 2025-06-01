<?php
session_start();
include('../backend/includes/db_connect.php');

if (!isset($_SESSION['userid'])) {
    echo "<p class='text-danger text-center mt-4'>You must be logged in to view your cart.</p>";
    exit;
}

$userid = $_SESSION['userid'];

$query = "
    SELECT c.product_id, c.quantity, p.name, p.image, p.price
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $userid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$cartItems = [];
$total = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $cartItems[] = $row;
    $total += $row['price'] * $row['quantity'];
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Your Cart</title>
        <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php include 'includes/topbar.php'; ?>
        <main class="container flex-grow-1 py-5">
            <h2 class="mb-4 text-center">Shopping Cart</h2>

            <?php if (empty($cartItems)): ?>
            <div class="alert alert-info text-center">Your cart is empty.</div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="60"></td>
                                <td>$<?= number_format($item['price'], 2) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <tr class="table-secondary">
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td class="fw-bold">$<?= number_format($total, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </main>
        <?php include 'includes/footer.php'; ?>
        
        <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
        <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    </body>
</html>
