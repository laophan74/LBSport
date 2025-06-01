document.addEventListener("DOMContentLoaded", async () => {
    const container = document.getElementById('order-container');

    try {
        const res = await fetch('../backend/controllers/get_order_history.php');
        const data = await res.json();

        if (data.status === 'success') {
            if (data.orders.length === 0) {
                container.innerHTML = `<div class="alert alert-info text-center">No orders found.</div>`;
                return;
            }

            container.innerHTML = data.orders.map(order => `
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Order #${order.order_id}</h5>
                        <p class="card-text">Date: ${order.order_date}</p>
                        <p class="card-text">Total: $${order.total_amount}</p>
                        <p class="card-text"><strong>Status:</strong> ${order.status}</p>
                        <a href="order_detail.php?order_id=${order.order_id}" class="btn btn-outline-primary me-2">View Details</a>
                        ${order.status === 'processing' ? `<button class="btn btn-outline-danger cancel-btn" data-id="${order.order_id}">Cancel Order</button>` : ''}
                    </div>
                </div>
            `).join('');

            document.querySelectorAll('.cancel-btn').forEach(button => {
                button.addEventListener('click', async () => {
                    const orderId = button.getAttribute('data-id');
                    if (!confirm("Are you sure you want to cancel this order?")) return;

                    try {
                        const res = await fetch('../backend/controllers/cancel_order.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ order_id: orderId })
                        });
                        const result = await res.json();

                        if (result.status === 'success') {
                            alert('Order cancelled successfully.');
                            location.reload();
                        } else {
                            alert(result.message || 'Failed to cancel order.');
                        }
                    } catch (err) {
                        alert('Error cancelling order.');
                        console.error(err);
                    }
                });
            });

        } else {
            container.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    } catch (error) {
        console.error(error);
        container.innerHTML = `<div class="alert alert-danger">Failed to load order history.</div>`;
    }
});
