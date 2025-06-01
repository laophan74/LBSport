<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('Location: login_form.php');
    exit();
}
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

        <main class="container flex-grow-1 py-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
            <h2 class="mb-4">Order History</h2>
            <div id="order-container" class="w-100" style="max-width: 700px;">Loading...</div>
        </main>

        <?php include 'includes/footer.php'; ?>

        <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="assets/js/order_history.js"></script>
    </body>
</html>
