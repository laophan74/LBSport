$(document).ready(function () {
    showTab('products');
    fetchProducts();
});

function showTab(tabName) {
    $('#tab-products, #tab-orders, #tab-users').hide();
    $('#tab-' + tabName).show();
    hideForm();
    hideOrderForm();

    if (tabName === 'products') fetchProducts();
    if (tabName === 'orders') fetchOrders();
    if (tabName === 'users') fetchUsers();
}

// ================= PRODUCTS ===================
function fetchProducts() {
    $.getJSON("../backend/controllers/products.php", function (data) {
        let rows = '';
        data.forEach(p => {
            rows += `<tr>
                <td>${p.id}</td>
                <td>${p.name}</td>
                <td><img src="${p.image}" width="50"></td>
                <td>${p.price}</td>
                <td>${p.type ?? ''}</td>
                <td>${p.description}</td>
                <td>${p.stock}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editProduct(${p.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteProduct(${p.id})">Delete</button>
                </td>
            </tr>`;
        });
        $('#product-table tbody').html(rows);
    });
}

function showAddForm() {
    $('#form-title').text('Add Product');
    $('#product-form').show();
    $('#product-table-container').hide();
    $('#product-id').val('');
    $('#name, #image, #price, #description, #stock').val('');
    $('#type').val('');
}

function editProduct(id) {
    $.getJSON(`../backend/controllers/products.php?id=${id}`, function (data) {
        $('#form-title').text('Edit Product');
        $('#product-form').show();
        $('#product-table-container').hide();
        $('#product-id').val(data.id);
        $('#name').val(data.name);
        $('#image').val(data.image);
        $('#price').val(data.price);
        $('#type').val(data.type);
        $('#description').val(data.description);
        $('#stock').val(data.stock);
    });
}

function submitForm(e) {
    e.preventDefault();
    const data = {
        id: $('#product-id').val(),
        name: $('#name').val(),
        image: $('#image').val(),
        price: $('#price').val(),
        type: $('#type').val(),
        description: $('#description').val(),
        stock: $('#stock').val()
    };

    const method = data.id ? "PUT" : "POST";
    const payload = data.id ? $.param(data) : JSON.stringify(data);
    const options = {
        url: "../backend/controllers/products.php",
        type: method,
        data: payload,
        success: () => {
            hideForm();
            fetchProducts();
        }
    };

    if (!data.id) options.contentType = "application/json";
    $.ajax(options);
}

function deleteProduct(id) {
    if (!confirm("Are you sure to delete this product?")) return;
    $.ajax({
        url: "../backend/controllers/products.php",
        type: "DELETE",
        data: { id: id },
        success: function () {
            fetchProducts();
        }
    });
}

function hideForm() {
    $('#product-form').hide();
    $('#product-table-container').show();
}

// ================= ORDERS ===================
function fetchOrders() {
    $.getJSON("../backend/controllers/orders.php", function (data) {
        let rows = '';
        data.forEach(o => {
            rows += `<tr>
                <td>${o.order_id}</td>
                <td>${o.user_id}</td>
                <td>${o.order_date}</td>
                <td>$${parseFloat(o.total_amount).toFixed(2)}</td>
                <td>${o.status}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editOrder(${o.order_id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteOrder(${o.order_id})">Delete</button>
                </td>
            </tr>`;
        });
        $('#order-table tbody').html(rows);
    });
}

function showOrderForm() {
    $('#order-form-title').text('Add Order');
    $('#order-form').show();
    $('#order-table-container').hide();
    $('#order-id').val('');
    $('#order-user-id').val('');
    $('#order-total').val('');
    $('#order-status').val('pending');
}

function editOrder(id) {
    $.getJSON(`../backend/controllers/orders.php`, function (response) {
        let order;

        if (Array.isArray(response)) {
            order = response.find(o => o.order_id == id);
        } else if (response.status === 'success' && Array.isArray(response.orders)) {
            order = response.orders.find(o => o.order_id == id);
        }

        if (!order) {
            alert('Order not found.');
            return;
        }

        $('#order-form-title').text('Edit Order');
        $('#order-form').show();
        $('#order-table-container').hide();
        $('#order-id').val(order.order_id);
        $('#order-user-id').val(order.user_id);
        $('#order-total').val(order.total_amount);
        $('#order-status').val(order.status);
    });
}

function submitOrderForm(e) {
    e.preventDefault();
    const data = {
        order_id: $('#order-id').val(),
        user_id: $('#order-user-id').val(),
        total_amount: $('#order-total').val(),
        status: $('#order-status').val()
    };

    const method = data.order_id ? "PUT" : "POST";
    const payload = data.order_id ? $.param(data) : JSON.stringify(data);
    const options = {
        url: "../backend/controllers/orders.php",
        type: method,
        data: payload,
        success: () => {
            hideOrderForm();
            fetchOrders();
        }
    };

    if (!data.order_id) options.contentType = "application/json";
    $.ajax(options);
}

function deleteOrder(id) {
    if (!confirm("Are you sure to delete this order?")) return;
    $.ajax({
        url: "../backend/controllers/orders.php",
        type: "DELETE",
        contentType: "application/json",
        data: JSON.stringify({ order_id: id }),
        success: function () {
            fetchOrders();
        }
    });
}

function hideOrderForm() {
    $('#order-form').hide();
    $('#order-table-container').show();
}

// ================= USERS ===================
function fetchUsers() {
    $.getJSON("../backend/controllers/auth.php", function (data) {
        let rows = '';
        data.forEach(u => {
            rows += `<tr>
                <td>${u.id}</td>
                <td>${u.username}</td>
                <td>${u.email}</td>
                <td>${u.role}</td>
                <td>${u.created_at}</td>
            </tr>`;
        });
        $('#user-table tbody').html(rows);
    });
}
