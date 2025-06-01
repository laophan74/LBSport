document.addEventListener('DOMContentLoaded', loadCart);

async function loadCart() {
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
                <tr data-product-id="${item.product_id}">
                    <td>${escapeHtml(item.name)}</td>
                    <td><img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}" width="60"></td>
                    <td>$${Number(item.price).toFixed(2)}</td>
                    <td>
                        <input type="number" class="form-control quantity-input" min="1" value="${item.quantity}" data-cart-id="${item.cart_id}" style="width: 80px; display: inline-block;">
                        <button class="btn btn-sm btn-primary update-btn ms-2">Update</button>
                    </td>
                    <td>$${(item.price * item.quantity).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-danger remove-btn" data-cart-id="${item.cart_id}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            `).join('');

            rows += `
                <tr class="table-secondary">
                    <td colspan="4" class="text-end fw-bold">Total</td>
                    <td class="fw-bold">$${data.total.toFixed(2)}</td>
                    <td></td>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>
            `;

            attachEventListeners();
        } else {
            container.innerHTML = `<div class="alert alert-danger text-center">${data.message}</div>`;
        }
    } catch (error) {
        console.error(error);
        container.innerHTML = `<div class="alert alert-danger text-center">Error loading cart.</div>`;
    }
}

function attachEventListeners() {
    document.querySelectorAll('.update-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const row = e.target.closest('tr');
            const cartId = row.querySelector('.quantity-input').dataset.cartId;
            const quantity = row.querySelector('.quantity-input').value;

            const res = await fetch('../backend/controllers/update_cart_item.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: cartId, quantity: quantity })
            });

            const data = await res.json();
            if (data.status === 'success') {
                loadCart();
            } else {
                alert(data.message);
            }
        });
    });

    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const row = e.target.closest('tr');
            const cartId = row.querySelector('.remove-btn').dataset.cartId;

            if (!confirm('Remove this item from cart?')) return;

            const res = await fetch('../backend/controllers/remove_cart_item.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: cartId })
            });

            const data = await res.json();
            if (data.status === 'success') {
                loadCart();
            } else {
                alert(data.message);
            }
        });
    });
}

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
