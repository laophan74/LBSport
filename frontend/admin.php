<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - LBSport</title>
    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/topbar.css">

</head>
<body>

<?php include 'includes/topbar_admin.php'; ?>

<div class="d-flex">
    <nav id="sidebar" class="bg-dark text-white p-3 vh-100">
        <h4 class="mb-4">Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link text-white" href="#" onclick="showTab('products')"><i class="fas fa-box"></i> Products</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" onclick="showTab('orders')"><i class="fas fa-receipt"></i> Orders</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" onclick="showTab('users')"><i class="fas fa-users"></i> Users</a></li>
        </ul>
    </nav>

    <main class="p-4 w-100" id="main-content">

        <!-- PRODUCTS TAB -->
        <section id="tab-products">
            <h2>Product Management</h2>
            <button class="btn btn-success my-2" onclick="showAddForm()">Add Product</button>
            <div id="product-table-container" class="table-responsive">
                <table class="table table-bordered table-striped" id="product-table">
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Image</th><th>Price</th><th>Type</th><th>Description</th><th>Stock</th><th>Actions</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="product-form" class="mt-4" style="display:none;">
                <h5 id="form-title">Add Product</h5>
                <form onsubmit="submitForm(event)">
                    <input type="hidden" id="product-id">
                    <div class="mb-2"><input type="text" class="form-control" id="name" placeholder="Product Name" required></div>
                    <div class="mb-2"><input type="text" class="form-control" id="image" placeholder="Image Path" required></div>
                    <div class="mb-2"><input type="number" class="form-control" id="price" step="0.01" placeholder="Price" required></div>
                    <div class="mb-2">
                        <select class="form-control" id="type" required>
                            <option value="">Select Type</option>
                            <option value="football">Football</option>
                            <option value="tennis">Tennis</option>
                            <option value="badminton">Badminton</option>
                        </select>
                    </div>
                    <div class="mb-2"><textarea class="form-control" id="description" placeholder="Description"></textarea></div>
                    <div class="mb-2"><input type="number" class="form-control" id="stock" placeholder="Stock Quantity" required></div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="hideForm()">Cancel</button>
                </form>
            </div>
        </section>

        <!-- ORDERS TAB -->
        <section id="tab-orders" style="display:none;">
            <h2>Orders Management</h2>
            <div id="order-table-container" class="table-responsive">
                <table class="table table-bordered table-striped" id="order-table">
                    <thead>
                        <tr><th>Order ID</th><th>User ID</th><th>Order Date</th><th>Total</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="order-form" class="mt-4" style="display:none;">
                <h5 id="order-form-title">Add Order</h5>
                <form onsubmit="submitOrderForm(event)">
                    <input type="hidden" id="order-id">
                    <div class="mb-2"><input type="number" class="form-control" id="order-user-id" placeholder="User ID" required></div>
                    <div class="mb-2"><input type="number" step="0.01" class="form-control" id="order-total" placeholder="Total Amount" required></div>
                    <div class="mb-2">
                        <select class="form-control" id="order-status" required>
                            <option value="pending">pending</option>
                            <option value="processing">processing</option>
                            <option value="shipped">shipped</option>
                            <option value="delivered">delivered</option>
                            <option value="cancelled">cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="hideOrderForm()">Cancel</button>
                </form>
            </div>
        </section>

        <!-- USERS TAB -->
        <section id="tab-users" style="display:none;">
            <h2>User List</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="user-table">
                    <thead>
                        <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Created At</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </main>
</div>

<script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
<script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
<script src="assets/js/admin.js"></script>
</body>
</html>
