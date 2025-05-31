<?php
header('Content-Type: application/json');

// Database config
$host = "localhost";
$db = "db_22121468";
$user = "221215468";
$pass = "Laobob123";

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit();
}

// Get POST data
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($email) || empty($password)) {
    echo json_encode([
        "success" => false,
        "message" => "Email and password are required."
    ]);
    exit();
}

// Find user by email
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo json_encode([
        "success" => false,
        "message" => "Email not found."
    ]);
    exit();
}

$user = $result->fetch_assoc();

// ✅ password_verify only works if passwords are hashed in DB
if (password_verify($password, $user['password'])) {
    echo json_encode([
        "success" => true,
        "username" => $user['username'],
        "role" => $user['role']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Incorrect password."
    ]);
}

$conn->close();
?>
