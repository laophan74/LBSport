<?php session_start(); ?>
<header class="fixed-top bg-white shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <a class="navbar-brand fw-bold" href="home copy.php">LBSport</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <form class="d-flex me-3">
            <input class="form-control me-2" type="search" placeholder="Search products" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">
            <i class="fas fa-search"></i>
            </button>
        </form>

        <ul class="navbar-nav">
            <li class="nav-item me-3">
            <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
            </li>
            <li class="nav-item me-2">
            <?php if (isset($_SESSION['username'])): ?>
                <a class="nav-link" href="account.php"><i class="fas fa-user"></i> Hello, <?= htmlspecialchars($_SESSION['username']) ?>!</a>
            <?php else: ?>
                <a class="nav-link" href="login_form.php"><i class="fas fa-user"></i> Account</a>
            <?php endif; ?>
            </li>
        </ul>
        </div>
    </nav>
</header>
