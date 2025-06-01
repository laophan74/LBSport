$(document).ready(function () {
    $.get('../backend/controllers/get_order_history.php', function (data) {
        const container = $('#order-container');

        if (!data || data.length === 0) {
            container.html('<p>You have no orders yet.</p>');
            return;
        }

        let html = '';
        data.forEach(order => {
            html += `
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Order #${order.order_id}</strong>
                        <span class="text-muted">- ${order.order_date}</span>
                        <span class="badge bg-info text-dark float-end">${order.status}</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-3">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
            `;

            order.items.forEach(item => {
                html += `
                    <tr>
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>$${parseFloat(item.price).toFixed(2)}</td>
                        <td>$${(item.quantity * item.price).toFixed(2)}</td>
                    </tr>
                `;
            });

            html += `
                            </tbody>
                        </table>
                        <h5 class="text-end">Total: $${parseFloat(order.total_amount).toFixed(2)}</h5>
                    </div>
                </div>
            `;
        });

        container.html(html);
    }, 'json');
});
