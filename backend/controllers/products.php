<?php
header('Content-Type: application/json');
require('../includes/connect_db.php');

// Kiểm tra nếu có truy vấn theo ID sản phẩm
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($dbc, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }

    mysqli_close($dbc);
    exit;
}

// Nếu không có id, trả về toàn bộ danh sách sản phẩm
$query = "SELECT * FROM products";
$result = mysqli_query($dbc, $query);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

echo json_encode($products);
mysqli_close($dbc);
?>
