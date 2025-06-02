<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results - LBSport</title>
    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<?php include 'includes/topbar.php'; ?>

<div class="container" style="margin-top: 100px;">
    <h2>Search Results</h2>
    <p id="result-count" class="text-muted"></p>
    <div id="search-results" class="row mt-4"></div>
</div>

<script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
<script src="assets/js/search.js"></script>
<script src="assets/js/product-detail.js"></script>
</body>
</html>
