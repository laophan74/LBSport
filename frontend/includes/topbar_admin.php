<?php session_start(); ?>
<header class="fixed-top bg-white shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <a class="navbar-brand fw-bold" href="admin.php">LBSport Admin</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="adminNavbar">
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item me-3">
                        <span class="nav-link"><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['username']) ?></span>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login_form.php" class="btn btn-outline-primary btn-sm">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
