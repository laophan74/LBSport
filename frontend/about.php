<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <title>About Us - LBSport</title>
    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css" />
    <style>
        /* Simple styling for about page */
        .about-section {
        padding: 60px 20px;
        max-width: 900px;
        margin: 0 auto;
        }
    </style>
    </head>
    <body>

    <?php include 'includes/topbar.php'; ?>

    <main class="about-section">
    <h1>About LBSport</h1>
    <p>
        Welcome to LBSport — your trusted source for top-quality sports gear and apparel.
    </p>
    <p>
        At LBSport, we are passionate about helping athletes and sports enthusiasts
        of all levels perform at their best by providing high-quality equipment,
        reliable customer service, and expert advice.
    </p>
    <h2>Our Mission</h2>
    <p>
        To empower athletes and fitness lovers by offering the best gear that
        combines performance, durability, and style — all at affordable prices.
    </p>
    <h2>Why Choose Us?</h2>
    <ul>
        <li>Wide range of products across multiple sports</li>
        <li>Trusted brands and quality assurance</li>
        <li>Exceptional customer support</li>
        <li>Easy returns and fast shipping</li>
    </ul>
    <h2>Meet the Team</h2>
    <p>
        Our team is composed of sports enthusiasts and experts committed to
        delivering the best experience.
    </p>

    <hr />

    <p>For inquiries, feel free to <a href="contact_form.php">contact us</a>.</p>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>

    </body>
</html>
