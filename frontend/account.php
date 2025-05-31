<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: ../backend/login_form.php');
    exit();
}

include '../backend/includes/db_connect.php';

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT email, role FROM users WHERE id = ?");
$stmt->bind_param("s", $userid);
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
                <div class="col-md-6">
                    <h2 class="mb-3">Welcome, <?= htmlspecialchars($username) ?>!</h2>
                    <hr />
                    <h4>Your Information</h4>
                    <form action="update_profile.php" method="POST">
                        <div class="row mb-3 align-items-center">
                            <label for="username" class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($username) ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-8 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="logout.php" class="btn btn-danger">Logout</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <?php include 'includes/footer.php'; ?>

        <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
        
        <script>
            function toggleEdit(fieldId, btn) {
                const $input = $('#' + fieldId);
                const $btn = $(btn);

                if ($input.is('[readonly]')) {
                    $input.removeAttr('readonly').focus();
                    $btn.text('Lock')
                        .removeClass('btn-outline-secondary')
                        .addClass('btn-outline-danger');
                } else {
                    $input.attr('readonly', true);
                    $btn.text('Edit')
                        .removeClass('btn-outline-danger')
                        .addClass('btn-outline-secondary');
                }
            }
        </script>
    </body>
</html>
