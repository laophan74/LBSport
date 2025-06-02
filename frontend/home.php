<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Home - LBSport</title>
    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
    </head>
    <body>

    <?php include 'includes/topbar.php'; ?>

    <section class="sport-showcase">
        <div class="container text-white text-center py-5">
        <h1>Explore Sports Gear at LBSport</h1>
        <p>Everything you need for training, competition, and recovery.</p>
        </div>
    </section>

    <section class="container py-5">
        <h2 class="mt-5">Football Gear</h2>
        <div class="row" id="football-products"></div>

        <h2 class="mt-5">Tennis Gear</h2>
        <div class="row" id="tennis-products"></div>

        <h2 class="mt-5">Badminton Gear</h2>
        <div class="row" id="badminton-products"></div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
    <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/js/home.js"></script>
    </body>
</html>
