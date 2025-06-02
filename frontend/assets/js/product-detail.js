$(document).ready(function () {
  const productId = new URLSearchParams(window.location.search).get("id");

  function renderStars(rating) {
    return Array.from({ length: 5 }, (_, i) =>
      `<span class="text-warning">${i < rating ? "★" : "☆"}</span>`
    ).join('');
  }

  $.get(`../backend/controllers/products.php?id=${productId}`, function (product) {
    if (!product) {
      $('.detail-box').html("<p>Product not found.</p>");
      return;
    }

    $('#product-name').text(product.name);
    $('#product-image').attr('src', product.image);
    $('#product-price').text(`$${product.price}`);
    $('#product-rating').html(renderStars(product.rating));
    $('#product-description').text(product.description);

    $('#addToCartBtn').click(function () {
      const quantity = parseInt($('#quantity').val()) || 1;

      $.ajax({
        url: '../backend/controllers/cart.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ product_id: product.id, quantity }),
        success: function (res) {
          alert(res.status === 'success' ? 'Added to cart!' : res.message);
        }
      });
    });
  });

  $.get(`../backend/controllers/reviews.php?product_id=${productId}`, function (reviews) {
    const $reviewList = $('#review-list').empty();

    if (!reviews.length) {
      $reviewList.html("<p>No reviews yet.</p>");
      return;
    }

    reviews.forEach(r => {
      $reviewList.append(`
        <div class="review-item mb-3">
          <strong>${r.username}</strong>
          <span class="text-muted small">(${new Date(r.created_at).toLocaleDateString()})</span>
          <div class="text-warning mb-1">${renderStars(r.rating)}</div>
          <p>${r.comment}</p>
        </div>
      `);
    });
  });
});
