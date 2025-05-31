<?php
session_start();

// Redirect if not admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: home.html');
//     exit();
// }

// Include DB connection
// require_once 'includes/connect_db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - LBSport</title>
  <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
</head>
<body>

<?php include 'includes/topbar.php'; ?>

<div class="admin-container container py-5">
  <h1 class="text-center mb-4">Admin Dashboard</h1>

  <!-- Product Management -->
  <div class="admin-section mb-5">
    <h2>Manage Products</h2>
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Image</th>
          <th>Price ($)</th>
          <th>Rating</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM products");
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td><img src="' . $row['image'] . '" width="60"></td>';
            echo '<td>' . number_format($row['price'], 2) . '</td>';
            echo '<td>' . $row['rating'] . '</td>';
            echo '<td>' . htmlspecialchars($row['description']) . '</td>';
            echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- User Management -->
  <div class="admin-section">
    <h2>Manage Users</h2>
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM users");
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . $row['role'] . '</td>';
            echo '<td>' . $row['created_at'] . '</td>';
            echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
