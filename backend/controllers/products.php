<?php
require('../includes/connect_db.php');

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if ($id) {
  // Fetch one product by ID
  $stmt = mysqli_prepare($dbc, "SELECT * FROM products WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  if ($row) {
    // Update image path for frontend
    $row['image'] = 'assets/img/' . basename($row['image']);
  }
  echo json_encode($row);
} else {
  // Fetch all products
  $query = "SELECT * FROM products ORDER BY id ASC";
  $result = mysqli_query($dbc, $query);

  $products = [];
  while ($row = mysqli_fetch_assoc($result)) {
    // Update image path to match actual location relative to home.html
    $row['image'] = 'assets/img/' . basename($row['image']);
    $products[] = $row;
  }

  echo json_encode($products);
}
?>
