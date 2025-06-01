document.addEventListener("DOMContentLoaded", async () => {
    const container = document.getElementById('order-detail');
    const orderId = container.dataset.orderId;

    try {
        const res = await fetch(`../backend/controllers/get_order_detail.php?order_id=${orderId}`);
        const data = await res.json();

        if (data.status === 'success') {
            const yellowStar = '<i class="fas fa-star fa-xs yellow-star"></i>';

            const itemsHTML = data.items.map(item => {
                const reviewed = item.review !== null;
                const reviewSection = reviewed
                    ? `
                        <div class="review-display" data-product-id="${item.product_id}">
                            <strong>Your Review:</strong>
                            ${yellowStar.repeat(item.review.rating)}<br />
                            <span class="review-comment">${item.review.comment}</span><br />
                            <button class="btn btn-sm btn-outline-secondary edit-btn mt-2" data-product-id="${item.product_id}">Edit Review</button>
                            <button class="btn btn-sm btn-outline-danger delete-btn mt-2" data-product-id="${item.product_id}">Delete Review</button>
                        </div>
                        <form class="review-form d-none mt-3" data-product-id="${item.product_id}">
                            <div class="mb-2 rating-stars" role="radiogroup" aria-label="Rating">
                                ${[1,2,3,4,5].map(n => `
                                <input type="radio" id="star${n}-${item.product_id}" name="rating" value="${n}" ${item.review.rating == n ? 'checked' : ''} />
                                <label for="star${n}-${item.product_id}" title="${n} stars">${yellowStar.repeat(n)}</label>
                                `).join('')}
                            </div>
                            <div class="mb-2">
                                <label>Comment:</label>
                                <textarea name="comment" class="form-control" required>${item.review.comment}</textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Update Review</button>
                            <button type="button" class="btn btn-sm btn-secondary cancel-btn">Cancel</button>
                        </form>`
                    : `
                        <form class="review-form" data-product-id="${item.product_id}">
                            <div class="mb-2 rating-stars" role="radiogroup" aria-label="Rating">
                                ${[1,2,3,4,5].map(n => `
                                <input type="radio" id="star${n}-${item.product_id}" name="rating" value="${n}" required />
                                <label for="star${n}-${item.product_id}" title="${n} stars">${yellowStar.repeat(n)}</label>
                                `).join('')}
                            </div>
                            <div class="mb-2">
                                <label>Comment:</label>
                                <textarea name="comment" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Submit Review</button>
                        </form>`;

                return `
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body d-flex">
                            <img src="${item.image}" alt="${item.name}" class="order_detail_img" />
                            <div style="flex: 1;">
                                <h5>${item.name}</h5>
                                <p>Price: $${item.price} × ${item.quantity} = $${(item.price * item.quantity).toFixed(2)}</p>
                                ${reviewSection}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            container.innerHTML = itemsHTML;

            // Handle form submission
            document.querySelectorAll('.review-form').forEach(form => {
                form.addEventListener('submit', async e => {
                    e.preventDefault();
                    const productId = form.dataset.productId;
                    const rating = form.rating.value;
                    const comment = form.comment.value;

                    const res = await fetch('../backend/controllers/submit_review.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ product_id: productId, rating, comment })
                    });

                    const result = await res.text();
                    if (result === 'success') {
                        location.reload();
                    } else {
                        alert(result);
                    }
                });
            });

            // Handle edit buttons
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const productId = button.dataset.productId;
                    const display = document.querySelector(`.review-display[data-product-id="${productId}"]`);
                    const form = document.querySelector(`.review-form[data-product-id="${productId}"]`);

                    if (display && form) {
                        display.classList.add('d-none');
                        form.classList.remove('d-none');
                    }
                });
            });

            // Handle cancel buttons
            document.querySelectorAll('.cancel-btn').forEach(button => {
                button.addEventListener('click', e => {
                    const form = e.target.closest('.review-form');
                    const productId = form.dataset.productId;
                    const display = document.querySelector(`.review-display[data-product-id="${productId}"]`);

                    form.classList.add('d-none');
                    if (display) {
                        display.classList.remove('d-none');
                    }
                });
            });

            // Handle delete review
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', async () => {
                    if (!confirm('Are you sure you want to delete your review?')) return;

                    const productId = button.dataset.productId;

                    const res = await fetch('../backend/controllers/delete_review.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ product_id: productId })
                    });

                    const result = await res.json();

                    if (result.status === 'success') {
                        location.reload();
                    } else {
                        alert(result.message || 'Failed to delete review.');
                    }
                });
            });

        } else {
            container.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    } catch (error) {
        console.error(error);
        container.innerHTML = `<div class="alert alert-danger">Failed to load order details.</div>`;
    }
});
