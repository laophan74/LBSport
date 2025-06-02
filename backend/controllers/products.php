<?php
header('Content-Type: application/json');
include('../includes/db_connect.php');

$method = $_SERVER['REQUEST_METHOD'];

// GET: Fetch all products or one by id
if ($method === 'GET') {
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
    exit;
}

// POST: Create a new product
if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare("INSERT INTO products (name, image, price, rating, description, stock) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdisi", $data['name'], $data['image'], $data['price'], $data['rating'], $data['description'], $data['stock']);
    $stmt->execute();

    echo json_encode(["id" => $stmt->insert_id]);
    mysqli_close($conn);
    exit;
}

// PUT: Update a product
if ($method === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);

    $stmt = $conn->prepare("UPDATE products SET name=?, image=?, price=?, rating=?, description=?, stock=? WHERE id=?");
    $stmt->bind_param("ssdisii", $data['name'], $data['image'], $data['price'], $data['rating'], $data['description'], $data['stock'], $data['id']);
    $stmt->execute();

    echo json_encode(["success" => true]);
    mysqli_close($conn);
    exit;
}

// DELETE: Remove a product
if ($method === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $id = intval($data['id']);

    mysqli_query($conn, "DELETE FROM products WHERE id = $id");

    echo json_encode(["success" => true]);
    mysqli_close($conn);
    exit;
}
?>
