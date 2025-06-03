<?php
session_start();
if (!isset($_SESSION['userid']) || !isset($_GET['order_id'])) {
    header('Location: order_history.php');
    exit();
}
$order_id = intval($_GET['order_id']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Order Detail</title>
        <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php include 'includes/topbar.php'; ?>

        <main class="container flex-grow-1 py-5 d-flex flex-column justify-content-center align-items-center">
            <h2 class="mb-4">Order Detail</h2>
            <div id="order-detail" class="w-100" style="max-width: 700px;" data-order-id="<?= $order_id ?>">Loading...</div>
            <div class="w-100 mb-3" style="max-width: 700px;">
                <a href="order_history.php" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Back to Order History
                </a>
            </div>
        </main>

        <?php include 'includes/footer.php'; ?>

        <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
        <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
        <script>
            const ORDER_ID = <?= $order_id ?>;
        </script>
        <script src="assets/js/orders.js"></script>
    </body>
</html>
