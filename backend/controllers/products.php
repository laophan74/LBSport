<?php
header('Content-Type: application/json');
require('../includes/db_connect.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }

    mysqli_close($conn);
    exit;
}

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

echo json_encode($products);
mysqli_close($conn);
?>
