$(document).ready(function () {
    // Load cart details
    $.get('../backend/controllers/cart.php', function (data) {
        if (data.status === 'success' && data.items.length > 0) {
            // If cart has items
            let html = '<h5>Order Summary</h5><table class="table table-bordered"><thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead><tbody>';
            
            data.items.forEach(item => {
                html += `<tr>
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>$${item.price}</td>
                    <td>$${(item.price * item.quantity).toFixed(2)}</td>
                </tr>`;
            });

            html += `<tr class="table-secondary">
                        <td colspan="3" class="text-end fw-bold">Total</td>
                        <td class="fw-bold">$${data.total.toFixed(2)}</td>
                     </tr></tbody></table>`;
            $('#cart-summary').html(html);
        } else {
            // If cart is empty
            $('#cart-summary').html('<div class="alert alert-info">Your cart is empty.</div>');
            $('#checkout-form').hide();
        }
    });

    // When payment method changes, show the related payment fields
    $('#payment-method').on('change', function () {
        $('.payment-form').hide().find('input').prop('disabled', true);
        const selected = $(this).val();
        if (selected) {
            $(`#form-${selected}`).show().find('input').prop('disabled', false);
        }
    });

    // Handle checkout form submission
    $('#checkout-form').on('submit', function (e) {
        e.preventDefault(); // Stop form from refreshing page

        if (!confirm('Are you sure you want to confirm this order?')) return;

        // Send order data to PHP
        $.ajax({
            url: '../backend/controllers/checkout.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                if (res.status === 'success') {
                    // If order placed, show success and redirect
                    $('#message').html(`<div class="alert alert-success">${res.message}</div>`);
                    setTimeout(() => location.href = 'order_history.php', 2000);
                } else {
                    $('#message').html(`<div class="alert alert-danger">${res.message}</div>`);
                }
            },
            error: function () {
                $('#message').html(`<div class="alert alert-danger">Server error. Please try again.</div>`);
            }
        });
    });
});
