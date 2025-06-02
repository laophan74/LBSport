<?php
header('Content-Type: application/json');
include('../includes/db_connect.php');

$result = mysqli_query($conn, "SELECT id, username, email, role, created_at FROM users");
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
echo json_encode($users);
mysqli_close($conn);
