<?php session_start(); ?>
<header class="bg-white shadow-sm">
    <nav class="navbar navbar-light container">
        <a class="navbar-brand fw-bold" href="admin.php">LBSport Admin</a>
        <div class="ms-auto">
            <?php if (isset($_SESSION['username'])): ?>
                <span class="me-3"><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            <?php else: ?>
                <a href="login_form.php" class="btn btn-outline-primary btn-sm">Login</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
