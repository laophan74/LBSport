<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: login_form.php');
    exit();
}

include '../backend/includes/db_connect.php';

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Account - LBSport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include 'includes/topbar.php'; ?>

    <main class="container flex-grow-1 py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <h2 class="mb-4 text-center">My Account</h2>

                <form id="accountForm">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($username) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Old Password</label>
                        <input type="password" id="oldPassword" name="oldPassword" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" id="newPassword" name="newPassword" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </form>

                <div id="msg" class="mt-3 text-center"></div>

                <div class="text-center mt-4">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
    <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/js/auth.js"></script>
</body>
</html>
