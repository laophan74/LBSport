<?php session_start(); ?>
<header class="fixed-top bg-white shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <a class="navbar-brand fw-bold" href="home.php">LBSport</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <div class="me-3 d-flex align-items-center">
            <a href="search.php" class="btn d-flex align-items-center gap-1 px-3 py-2 border border-2 shadow-sm"
            style="color: white; border-color: white;">
                <i class="fas fa-search"></i> <span class="d-none d-sm-inline">Search</span>
            </a>
        </div>


            <ul class="navbar-nav">
                <li class="nav-item me-3"><a class="nav-link" href="about.php"><i class="fas fa-info-circle"></i> About</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="contact_form.php"><i class="fas fa-envelope"></i> Contact</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="cart_form.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                <li class="nav-item dropdown me-2 position-relative">
                    <?php if (isset($_SESSION['userid'])): ?>
                        <a class="nav-link" href="account.php" id="userDropdown" role="button">
                            <i class="fas fa-user"></i> Hello, <?= htmlspecialchars($_SESSION['username']) ?>!
                        </a>
                        <ul class="dropdown-menu position-absolute start-0" aria-labelledby="userDropdown" style="top: 100%; display: none;">
                            <li><a class="dropdown-item" href="order_history.php">Order History</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    <?php else: ?>
                        <a class="nav-link" href="login_form.php"><i class="fas fa-user"></i> Account</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
