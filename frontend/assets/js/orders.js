$(document).ready(function () {
    const container = $('#order-container');

    if (container.length) {
        $.get('../backend/controllers/orders.php', function (res) {
            if (res.status === 'success') {
                if (res.orders.length === 0) {
                    container.html(`<div class="alert alert-info text-center">No orders found.</div>`);
                    return;
                }

                let html = '';
                res.orders.forEach(order => {
                    html += `
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Order #${order.order_id}</h5>
                            <p class="card-text">Date: ${order.order_date}</p>
                            <p class="card-text">Total: $${order.total_amount}</p>
                            <p class="card-text"><strong>Status:</strong> ${order.status}</p>
                            <a href="order_detail.php?order_id=${order.order_id}" class="btn btn-outline-primary me-2">View Details</a>
                            ${order.can_cancel
                                ? `<button class="btn btn-outline-danger cancel-btn" data-id="${order.order_id}">Cancel Order</button>`
                                : ''}
                        </div>
                    </div>`;
                });

                container.html(html);
            } else {
                container.html(`<div class="alert alert-danger">${res.message}</div>`);
            }
        });

        $(document).on('click', '.cancel-btn', function () {
            const orderId = $(this).data('id');
            if (!confirm("Are you sure you want to cancel this order?")) return;

            $.ajax({
                url: '../backend/controllers/orders.php',
                method: 'DELETE',
                contentType: 'application/json',
                data: JSON.stringify({ order_id: orderId }),
                success: function (result) {
                    if (result.status === 'success') {
                        alert('Order cancelled successfully.');
                        location.reload();
                    } else {
                        alert(result.message || 'Failed to cancel order.');
                    }
                },
                error: function () {
                    alert('Error cancelling order.');
                }
            });
        });
    }

    const detailContainer = $('#order-detail');
    if (detailContainer.length) {
        $.get(`../backend/controllers/orders.php?order_id=${ORDER_ID}`, function (res) {
            if (res.status !== 'success') {
                detailContainer.html(`<div class="alert alert-danger">${res.message}</div>`);
                return;
            }

            const yellowStar = '<i class="fas fa-star fa-xs text-warning"></i>';
            const itemsHTML = res.items.map(item => {
                const reviewed = item.review !== null;
                const reviewHTML = reviewed ? `
                    <div class="review-display" data-product-id="${item.product_id}">
                        <strong>Your Review:</strong>
                        ${yellowStar.repeat(item.review.rating)}<br>
                        <span>${item.review.comment}</span><br>
                        <button class="btn btn-sm btn-outline-secondary edit-btn mt-2" data-product-id="${item.product_id}">Edit</button>
                        <button class="btn btn-sm btn-outline-danger delete-btn mt-2" data-product-id="${item.product_id}">Delete</button>
                    </div>
                    <form class="review-form d-none mt-3" data-product-id="${item.product_id}">
                        <div class="mb-2">${[1,2,3,4,5].map(n => `<input type="radio" name="rating" value="${n}" ${item.review.rating==n ? 'checked' : ''}> ${n}`).join(' ')}</div>
                        <textarea name="comment" class="form-control mb-2">${item.review.comment}</textarea>
                        <button class="btn btn-sm btn-primary">Update</button>
                        <button type="button" class="btn btn-sm btn-secondary cancel-btn">Cancel</button>
                    </form>
                ` : `
                    <form class="review-form mt-2" data-product-id="${item.product_id}">
                        <div class="mb-2">${[1,2,3,4,5].map(n => `<input type="radio" name="rating" value="${n}"> ${n}`).join(' ')}</div>
                        <textarea name="comment" class="form-control mb-2"></textarea>
                        <button class="btn btn-sm btn-primary">Submit Review</button>
                    </form>`;

                return `
                    <div class="card mb-3">
                        <div class="card-body d-flex">
                            <img src="${item.image}" alt="${item.name}" class="me-3" width="80">
                            <div>
                                <h5>${item.name}</h5>
                                <p>$${item.price} × ${item.quantity} = $${(item.price * item.quantity).toFixed(2)}</p>
                                ${reviewHTML}
                            </div>
                        </div>
                    </div>`;
            }).join('');

            detailContainer.html(itemsHTML);

            $('.review-form').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const productId = form.data('product-id');
                const rating = form.find('input[name="rating"]:checked').val();
                const comment = form.find('textarea[name="comment"]').val();

                $.post('../backend/controllers/submit_review.php', JSON.stringify({ product_id: productId, rating, comment }), function (res) {
                    if (res === 'success') location.reload();
                    else alert(res);
                }, 'text');
            });

            $('.edit-btn').on('click', function () {
                const id = $(this).data('product-id');
                $(`.review-display[data-product-id='${id}']`).hide();
                $(`.review-form[data-product-id='${id}']`).removeClass('d-none');
            });

            $('.cancel-btn').on('click', function () {
                const form = $(this).closest('.review-form');
                const id = form.data('product-id');
                form.addClass('d-none');
                $(`.review-display[data-product-id='${id}']`).show();
            });

            $('.delete-btn').on('click', function () {
                const id = $(this).data('product-id');
                if (!confirm('Delete this review?')) return;
                $.post('../backend/controllers/delete_review.php', JSON.stringify({ product_id: id }), function (res) {
                    if (res.status === 'success') location.reload();
                    else alert(res.message);
                }, 'json');
            });
        });
    }
});
