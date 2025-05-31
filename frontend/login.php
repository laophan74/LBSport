<?php
session_start();

// Validate POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $conn = new mysqli("localhost", "22121468", "Laobob123", "db_22121468");

    if ($conn->connect_error) {
        echo "Database connection error.";
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        echo "Email not found.";
    } else {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            echo "success";
        } else {
            echo "Incorrect password.";
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>