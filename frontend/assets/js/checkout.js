document.addEventListener('DOMContentLoaded', async () => {
    const summary = document.getElementById('cart-summary');
    const paymentSelect = document.getElementById('payment-method');
    // Trigger initial disabling of unselected payment fields
    paymentSelect.dispatchEvent(new Event('change'));

    // Load cart items
    const res = await fetch('../backend/controllers/get_cart_items.php');
    const data = await res.json();

    if (data.status === 'success' && data.items.length > 0) {
        let html = '<h5>Order Summary</h5><table class="table table-bordered"><thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead><tbody>';
        data.items.forEach(item => {
            html += `<tr>
                <td>${item.name}</td>
                <td>${item.quantity}</td>
                <td>$${item.price}</td>
                <td>$${(item.quantity * item.price).toFixed(2)}</td>
            </tr>`;
        });
        html += `<tr class="table-secondary">
                    <td colspan="3" class="text-end fw-bold">Total</td>
                    <td class="fw-bold">$${data.total.toFixed(2)}</td>
                </tr>`;
        html += '</tbody></table>';
        summary.innerHTML = html;
    } else {
        summary.innerHTML = `<div class="alert alert-info">Your cart is empty.</div>`;
        document.getElementById('checkout-form').style.display = 'none';
    }

    // Show/hide payment form sections
    paymentSelect.addEventListener('change', () => {
        document.querySelectorAll('.payment-form').forEach(form => {
            form.style.display = 'none';
            // Disable all inputs inside
            form.querySelectorAll('input').forEach(input => input.disabled = true);
        });

        const selected = paymentSelect.value;
        if (selected) {
            const section = document.getElementById('form-' + selected);
            if (section) {
                section.style.display = 'block';
                // Enable only inputs in selected form
                section.querySelectorAll('input').forEach(input => input.disabled = false);
            }
        }
    });

    // Form submit
    document.getElementById('checkout-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!confirm('Are you sure you want to confirm this order?')) return;

        const formData = new FormData(e.target);
        const res = await fetch('../backend/controllers/process_checkout.php', {
            method: 'POST',
            body: formData
        });

        const result = await res.json();
        const message = document.getElementById('message');

        if (result.status === 'success') {
            message.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
            setTimeout(() => window.location.href = 'order_history.php', 2000);
        } else {
            message.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
        }
    });
});