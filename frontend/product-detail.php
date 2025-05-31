<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Product Detail - LBSport</title>
    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
    </head>
    <body>

    <?php include 'includes/topbar.php'; ?>

    <section class="product-detail-section py-5">
        <div class="container detail-box p-4 rounded shadow-sm bg-light">
        <div class="row">
            <div class="col-md-6 mb-4">
            <img id="product-image" src="" class="img-fluid rounded" alt="Product Image">
            </div>
            <div class="col-md-6">
            <h2 id="product-name" class="fw-bold mb-3"></h2>
            <p class="text-primary fs-4" id="product-price"></p>
            <p id="product-rating" class="text-warning mb-2"></p>
            <p id="product-description" class="mb-4"></p>

            <div class="mb-3">
                <label for="quantity" class="form-label fw-bold">Quantity</label>
                <input type="number" id="quantity" class="form-control" value="1" min="1" style="width: 120px;">
            </div>

            <button class="btn btn-success" id="addToCartBtn">Add to Cart</button>
            </div>
        </div>

        <hr class="my-5" />

        <div class="reviews-section">
            <h4>Customer Reviews</h4>
            <div id="review-list" class="mt-3"></div>
        </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
    <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    </body>
</html>
