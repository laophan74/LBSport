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
                        <a href="order_detail.php?order_id=${order.order_id}" class="btn btn-outline-primary">View Details</a>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    } catch (error) {
        console.error(error);
        container.innerHTML = `<div class="alert alert-danger">Failed to load order history.</div>`;
    }
});
