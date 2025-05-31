<?php
    $host = "localhost";
    $db = "db_22121468";
    $user = "221215468";
    $pass = "Laobob123";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $response = [];

    if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $response['success'] = true;
        $response['username'] = $user['username'];
        $response['role'] = $user['role'];
    } else {
        $response['success'] = false;
        $response['message'] = "Incorrect password.";
    }
    } else {
    $response['success'] = false;
    $response['message'] = "Email not found.";
    }

    echo json_encode($response);
    $conn->close();
?>
