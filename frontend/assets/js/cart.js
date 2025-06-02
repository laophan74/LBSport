
$(document).ready(function () {
    loadCart(); // Load cart items when page is ready

    // Function to load cart data from the server
    function loadCart() {
        $.getJSON('../backend/controllers/cart.php', function (res) {
            if (res.status === 'success') {
                if (res.items.length === 0) {
                    $('#cart-container').html(`<div class="alert alert-info">Your cart is empty.</div>`);
                    return;
                }

                // Create table rows for each item in cart
                let rows = res.items.map(item => `
                    <tr data-id="${item.cart_id}">
                        <td>${item.name}</td>
                        <td><img src="${item.image}" alt="${item.name}" width="60"></td>
                        <td>$${item.price.toFixed(2)}</td>
                        <td>
                            <input type="number" class="form-control qty" value="${item.quantity}" min="1" style="width: 80px; display:inline-block;">
                            <button class="btn btn-sm btn-primary update">Update</button>
                        </td>
                        <td>$${(item.price * item.quantity).toFixed(2)}</td>
                        <td><button class="btn btn-sm btn-danger remove"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                `).join('');

                // Add total row
                rows += `
                    <tr class="table-secondary">
                        <td colspan="4" class="text-end fw-bold">Total</td>
                        <td class="fw-bold">$${res.total.toFixed(2)}</td>
                        <td></td>
                    </tr>
                `;

                // Display table in the cart container
                $('#cart-container').html(`
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>${rows}</tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn btn-success" id="checkout-btn">Proceed to Checkout</button>
                    </div>
                `);
            } else {
                $('#cart-container').html(`<div class="alert alert-danger">${res.message}</div>`);
            }
        });
    }

    // When user clicks "Update" button to change quantity
    $('#cart-container').on('click', '.update', function () {
        const row = $(this).closest('tr'); // Get the row of the item
        const id = row.data('id'); // Get cart item ID
        const quantity = row.find('.qty').val(); // Get new quantity

        // Send update request to server
        $.ajax({
            url: '../backend/controllers/cart.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'update', id, quantity }),
            success: function (res) {
                if (res.status === 'success') loadCart();
                else alert(res.message);
            }
        });
    });

    // When user clicks "Remove" button to delete item
    $('#cart-container').on('click', '.remove', function () {
        if (!confirm('Remove this item?')) return;

        const id = $(this).closest('tr').data('id');

        $.ajax({
            url: '../backend/controllers/cart.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'remove', id }),
            success: function (res) {
                if (res.status === 'success') loadCart();
                else alert(res.message);
            }
        });
    });

    // When user clicks checkout button
    $('#cart-container').on('click', '#checkout-btn', function () {
        window.location.href = 'checkout.php';
    });
});
