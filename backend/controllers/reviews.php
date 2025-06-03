<?php
header('Content-Type: application/json');
include('../includes/db_connect.php');

if (!isset($_GET['product_id'])) {
    echo json_encode(['error' => 'Missing product_id']);
    exit;
}

$product_id = $_GET['product_id'];

$query = "
    SELECT r.rating, r.comment, r.created_at, u.username
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    WHERE r.product_id = $product_id
    ORDER BY r.created_at DESC
";

$result = mysqli_query($conn, $query);

$reviews = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reviews[] = $row;
}

echo json_encode($reviews);
mysqli_close($conn);
?>
