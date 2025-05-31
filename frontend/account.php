<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect non-logged-in users to login page
    header('Location: ../backend/login_form.php');
    exit();
}

include '../backend/includes/db_connect.php';

// Fetch user info from DB by email or username stored in session
// Assuming email is stored in session or username is unique key
$username = $_SESSION['username'];
// Let's get user details by username
$stmt = $conn->prepare("SELECT email, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // Something wrong, maybe user deleted?
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
    <body>

    <?php include 'includes/topbar.php'; ?>

    <div class="container" style="margin-top: 100px; margin-bottom: 60px;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Welcome, <?= htmlspecialchars($username) ?>!</h2>
                <hr />
                <h4>Your Information</h4>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Username:</strong> <?= htmlspecialchars($username) ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
                    <li class="list-group-item"><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></li>
                </ul>

                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    </body>
</html>
