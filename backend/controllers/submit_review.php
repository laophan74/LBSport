<?php
session_start();
header('Content-Type: text/plain');
include '../includes/db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$product_id = intval($data['product_id'] ?? 0);
$rating = intval($data['rating'] ?? 0);
$comment = trim($data['comment'] ?? '');
$user_id = $_SESSION['userid'] ?? 0;

if (!$product_id || !$rating || !$comment || $rating < 1 || $rating > 5) {
    echo "Invalid input.";
    exit;
}

// Check if a review already exists
$stmt = $conn->prepare("SELECT id FROM reviews WHERE product_id = ? AND user_id = ?");
$stmt->bind_param("ii", $product_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Update review
    $stmt->close();
    $stmt = $conn->prepare("UPDATE reviews SET rating = ?, comment = ? WHERE product_id = ? AND user_id = ?");
    $stmt->bind_param("isii", $rating, $comment, $product_id, $user_id);
} else {
    // Insert review
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);
}

if ($stmt->execute()) {
    // Calculate the average rating of the product
    $stmt->close();
    $stmt = $conn->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($avg_rating);
    $stmt->fetch();

    // Update the product rating in the products table
    $stmt->close();
    $stmt = $conn->prepare("UPDATE products SET rating = ? WHERE id = ?");
    $stmt->bind_param("di", $avg_rating, $product_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error updating product rating.";
    }
} else {
    echo "Error saving review.";
}

$conn->close();
?>
