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
        <meta charset="UTF-8" />
        <title>Order Detail</title>
        <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css" />
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?php include 'includes/topbar.php'; ?>

        <main class="container flex-grow-1 py-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
            <h2 class="mb-4">Order Detail</h2>
            <div id="order-detail" class="w-100" style="max-width: 700px;" data-order-id="<?= $order_id ?>">Loading...</div>
        </main>

        <?php include 'includes/footer.php'; ?>
        
        <script src="assets/js/order_detail.js" defer></script>
    </body>
</html>
