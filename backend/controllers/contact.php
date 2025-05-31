<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Contact Submitted - LBSport</title>
        <link rel="stylesheet" href="../../frontend/assets/libs/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="../../frontend/assets/libs/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="../../frontend/assets/css/main.css">
    </head>
    <body>

    <?php include '../../frontend/includes/topbar.php'; ?>

    <main class="container my-5 pt-5 text-center">
        <h2 class="mb-4">Thank You!</h2>
        <p>Your message has been successfully submitted. We will get back to you shortly.</p>
        <a href="../../frontend/home.php" class="btn btn-primary mt-3">Back to Home</a>
    </main>

    <?php include '../../frontend/includes/footer.php'; ?>

    <script src="../../frontend/assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    </body>
</html>
