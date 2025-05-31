<?php
    include 'includes/db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $email === '' || $password === '') {
            echo "All fields are required.";
            exit();
        }

        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "Email is already registered.";
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error during registration.";
        }

        $stmt->close();
        $check->close();
        $conn->close();
    } else {
        echo "Invalid request.";
    }
?>