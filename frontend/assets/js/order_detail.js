document.addEventListener("DOMContentLoaded", async () => {
    const container = document.getElementById('order-detail');
    const orderId = container.dataset.orderId;

    try {
        const res = await fetch(`../backend/controllers/get_order_detail.php?order_id=${orderId}`);
        const data = await res.json();

        if (data.status === 'success') {
            const itemsHTML = data.items.map(item => {
                const reviewed = item.review !== null;
                const yellowStar = '<i class="fas fa-star fa-xs yellow-star"></i>';
                const reviewSection = reviewed
                    ? `<div class="mt-2"><strong>Your Review:</strong> ${yellowStar.repeat(item.review.rating)}<br>${item.review.comment}</div>`
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
                            <img src="${item.image}" alt="${item.name}" style="width: 100px; height: auto; object-fit: contain; margin-right: 15px; border: 1px solid #ccc; border-radius: 4px;" />
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

            // Attach submit events
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

        } else {
            container.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    } catch (error) {
        console.error(error);
        container.innerHTML = `<div class="alert alert-danger">Failed to load order details.</div>`;
    }
});
