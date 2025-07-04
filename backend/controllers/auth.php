<?php
// Start session to keep user logged in
session_start();

header('Content-Type: application/json');
include('../includes/db_connect.php');

// Get action from request (like 'login' or 'register')
$action = $_POST['action'] ?? '';

// ============ REGISTER ============ //
if ($action === 'register') {
    // Get form input values
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email is already registered
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?"); //https://www.w3schools.com/php/php_mysql_prepared_statements.asp
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
        exit;
    }

    $role = 'customer';
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to register.']);
    }

    exit;
}

// ============ LOGIN ============ //
if ($action === 'login') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if user exists with the given email
    $stmt = $conn->prepare("SELECT id, username, role, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $role, $db_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && $password === $db_password) {
        // Save user data into session
        $_SESSION['userid'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        echo json_encode(['status' => 'success', 'role' => $role]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
    }

    exit;
}

// ============ GET ALL USERS (Admin Use) ============ //
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = mysqli_query($conn, "SELECT id, username, email, role, created_at FROM users");
    $users = [];

    while ($row = mysqli_fetch_assoc($result)) { //https://www.php.net/manual/en/mysqli-result.fetch-assoc.php
        $users[] = $row;
    }

    echo json_encode($users);
    exit;
}

// ============ UPDATE PASSWORD ============ //
if ($action === 'update_password') {
    // Get current user ID from session
    $userid = $_SESSION['userid'];
    $oldPassword = trim($_POST['oldPassword']); //https://www.php.net/trim
    $newPassword = trim($_POST['newPassword']);

    // Get the current password from DB
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $stmt->bind_result($currentPassword);
    $stmt->fetch();
    $stmt->close();

    if ($oldPassword !== $currentPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Old password is incorrect.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $newPassword, $userid);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update password.']);
    }

    exit;
}

// ============ INVALID REQUEST ============ //
echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
