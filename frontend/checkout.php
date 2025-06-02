<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
    <style>
        .payment-form { display: none; }
    </style>
</head>
<body>
    <?php include 'includes/topbar.php'; ?>

    <main class="container flex-grow-1 py-5">
        <h2 class="mb-4">Checkout</h2>
        
        <div id="cart-summary" class="mb-4">
            <p>Loading your cart...</p>
        </div>

        <form id="checkout-form">
            <div class="mb-3">
                <label class="form-label">Select Payment Method:</label>
                <select name="payment_method" id="payment-method" class="form-select" required>
                    <option value="">-- Select --</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>

            <!-- Credit Card Form -->
            <div class="payment-form" id="form-credit_card">
                <div class="mb-3">
                    <label class="form-label">Card Number</label>
                    <input type="text" class="form-control" name="card_number" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Expiry</label>
                    <input type="text" class="form-control" name="card_expiry" placeholder="MM/YY" required>
                </div>
            </div>

            <!-- PayPal Form -->
            <div class="payment-form" id="form-paypal">
                <div class="mb-3">
                    <label class="form-label">PayPal Email</label>
                    <input type="email" class="form-control" name="paypal_email" required>
                </div>
            </div>

            <!-- Bank Transfer Form -->
            <div class="payment-form" id="form-bank_transfer">
                <div class="mb-3">
                    <label class="form-label">Bank Account Number</label>
                    <input type="text" class="form-control" name="bank_account" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Shipping Address</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" required>
            </div>

            <div class="w-100 mb-3">
                <div class="d-flex justify-content-between">
                    <a href="cart_form.php" class="btn btn-outline-secondary mb-3">
                        <i class="fas fa-arrow-left"></i> Back to Cart
                    </a>

                    <button type="submit" class="btn btn-success mb-3">Confirm Order</button>
                </div>
            </div>
        </form>

        <div id="message" class="mt-4"></div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/js/checkout.js"></script>
</body>
</html>
