document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('cart-container');

    try {
        const res = await fetch('../backend/controllers/get_cart_items.php');
        const data = await res.json();

        if (data.status === 'success') {
            if (data.items.length === 0) {
                container.innerHTML = `<div class="alert alert-info text-center">Your cart is empty.</div>`;
                return;
            }

            let rows = data.items.map(item => `
                <tr>
                    <td>${escapeHtml(item.name)}</td>
                    <td><img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}" width="60"></td>
                    <td>$${Number(item.price).toFixed(2)}</td>
                    <td>${item.quantity}</td>
                    <td>$${(item.price * item.quantity).toFixed(2)}</td>
                </tr>
            `).join('');

            rows += `
                <tr class="table-secondary">
                    <td colspan="4" class="text-end fw-bold">Total</td>
                    <td class="fw-bold">$${data.total.toFixed(2)}</td>
                </tr>
            `;

            container.innerHTML = `
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>
            `;
        } else {
            container.innerHTML = `<div class="alert alert-danger text-center">${data.message}</div>`;
        }
    } catch (error) {
        console.error(error);
        container.innerHTML = `<div class="alert alert-danger text-center">Error loading cart.</div>`;
    }
});

function escapeHtml(text) {
    return text.replace(/[&<>"']/g, (char) => {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        };
        return map[char];
    });
}
