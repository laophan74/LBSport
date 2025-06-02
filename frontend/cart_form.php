<?php
session_start();

if (!isset($_SESSION['userid'])) {
    echo "<p class='text-danger text-center mt-4'>You must be logged in to view your cart.</p>";
    exit;
}
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
            <div id="cart-container">
                <p class="text-center">Loading cart...</p>
            </div>
        </main>

        <?php include 'includes/footer.php'; ?>
        
        <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script> 
        <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script> 
        <script src="assets/js/cart.js"></script>
    </body>
</html>
