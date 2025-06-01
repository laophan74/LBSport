<?php 

session_start(); 

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $email = $_POST['email'] ?? ''; 
    $password = $_POST['password'] ?? ''; 

    include '../includes/db_connect.php'; 

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?"); 
    $stmt->bind_param("s", $email); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 

    if ($result->num_rows !== 1) { 
        $response = [
            'status' => 'error',
            'message' => 'Email not found.'
        ]; 
    } else { 
        $user = $result->fetch_assoc(); 

        if ($password === $user['password']) { 
            $_SESSION['userid'] = $user['id']; 
            $_SESSION['username'] = $user['username']; 
            $_SESSION['role'] = $user['role'];

            $response = [
                'status' => 'success',
                'role' => $user['role']
            ];
        } else { 
            $response = [
                'status' => 'error',
                'message' => 'Incorrect password.'
            ];
        } 
    } 

    $stmt->close(); 
    $conn->close(); 
} else { 
    $response = [
        'status' => 'error',
        'message' => 'Invalid request.'
    ];
}

echo json_encode($response);
?>
