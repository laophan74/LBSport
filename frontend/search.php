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

    <!-- Filter section -->
    <div class="row g-3 mt-3 mb-4">
        <div class="col-md-3">
            <label for="searchQuery" class="form-label">Search</label>
            <input type="text" class="form-control" id="searchQuery" placeholder="e.g. racket, shoe">
        </div>
        <div class="col-md-3">
            <label for="typeFilter" class="form-label">Type</label>
            <select class="form-select" id="typeFilter">
                <option value="">All Types</option>
                <option value="football">Football</option>
                <option value="tennis">Tennis</option>
                <option value="badminton">Badminton</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="minPrice" class="form-label">Min Price</label>
            <input type="number" class="form-control" id="minPrice" placeholder="0">
        </div>
        <div class="col-md-2">
            <label for="maxPrice" class="form-label">Max Price</label>
            <input type="number" class="form-control" id="maxPrice" placeholder="999">
        </div>
        <div class="col-md-2 d-flex align-items-end gap-2">
            <button class="btn btn-primary w-100" id="applyFilters">Apply Filters</button>
            <button class="btn btn-secondary w-100" id="clearFilters">Clear</button>
        </div>
    </div>

    <p id="result-count" class="text-muted"></p>
    <div id="search-results" class="row mt-4"></div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
<script src="assets/js/search.js"></script>
<script src="assets/js/product-detail.js"></script>
</body>
</html>
