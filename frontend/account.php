<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: ../backend/login_form.php');
    exit();
}

include '../backend/includes/db_connect.php';

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
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
                    <h2 class="mb-3">Welcome, <?= htmlspecialchars($username) ?>!</h2>
                    <hr />
                    <h4>Your Information</h4>
                    <form action="update_profile.php" method="POST">
                        <div class="row mb-3 align-items-center">
                            <label for="username" class="col-3 col-form-label">Username</label>
                            <div class="col-6">
                                <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($username) ?>" readonly required>
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleEdit('username', this)">Edit</button>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="email" class="col-3 col-form-label">Email</label>
                            <div class="col-6">
                                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly required>
                            </div>
                            <div class="col-3">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleEdit('email', this)">Edit</button>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-4">
                            </div>
                            <div class="col-8 d-flex gap-2">
                                <button type="submit" id="saveBtn" class="btn btn-primary">Save</button>
                                <a href="logout.php" class="btn btn-danger">Logout</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Confirmation Modal -->
            <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="passwordConfirmForm">
                            <div class="modal-header">
                                <h5 class="modal-title" id="passwordModalLabel">Password Required</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="targetField" />
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Enter your password</label>
                                    <input type="password" class="form-control" id="confirmPassword" required>
                                    <div class="invalid-feedback">
                                        Incorrect password. Try again.
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>

        <?php include 'includes/footer.php'; ?>

        <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
        <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="assets/js/account.js"></script>
    </body>
</html>
