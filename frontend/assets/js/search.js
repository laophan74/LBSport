$(document).ready(function () {
  let allProducts = [];

  // Function to render stars for ratings
  function renderStars(rating) {
    return Array.from({ length: 5 }, (_, i) =>
      `<span class="text-warning">${i < rating ? "★" : "☆"}</span>`
    ).join('');
  }

  // Get the current value of the search input
  function getSearchQuery() {
    return $('#searchQuery').val().trim().toLowerCase();
  }

  // Read filter values from the UI
  function getFilters() {
    return {
      type: $('#typeFilter').val().trim().toLowerCase(),
      minPrice: parseFloat($('#minPrice').val()) || 0,
      maxPrice: parseFloat($('#maxPrice').val()) || Infinity
    };
  }

  // Render filtered products to the page
  function renderResults() {
    const query = getSearchQuery();
    const { type, minPrice, maxPrice } = getFilters();
    const $container = $('#search-results');

    const matches = allProducts.filter(p => {
      const nameMatch = p.name?.toLowerCase().includes(query);
      const descMatch = p.description?.toLowerCase().includes(query);
      const productType = (p.type || "").toLowerCase();
      const priceMatch = p.price >= minPrice && p.price <= maxPrice;
      const typeMatch = type === "" || productType === type;

      return (nameMatch || descMatch) && priceMatch && typeMatch;
    });

    $('#result-count').text(`${matches.length} result(s) found for "${query}"`);

    if (matches.length === 0) {
      $container.html("<p>No products found.</p>");
      return;
    }

    $container.html(matches.map(p => `
      <div class="col-md-4 mb-4">
        <div class="card product-card h-100" onclick="window.location.href='product-detail.php?id=${p.id}'" style="cursor: pointer;">
          <img src="${p.image}" class="card-img-top" alt="${p.name}">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">${p.name}</h5>
            <p class="text-warning">${renderStars(p.rating)}</p>
            <p class="text-primary fw-bold">$${p.price}</p>
            <p class="card-text">${p.description}</p>
            <div class="mt-auto d-flex align-items-center gap-2">
              <input type="number" class="form-control form-control-sm" id="qty-${p.id}" value="1" min="1" style="width: 60px;" onclick="event.stopPropagation()" onkeydown="event.stopPropagation()">
              <button class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation(); addToCart(${p.id}, $('#qty-${p.id}').val())">
                <i class="fas fa-cart-plus"></i> Add
              </button>
            </div>
          </div>
        </div>
      </div>
    `).join(''));
  }

  // Fetch and render products
  function fetchAndRenderResults() {
    $.get("../backend/controllers/products.php", function (products) {
      allProducts = products;
      renderResults();
    });
  }

  // Event listeners
  $('#applyFilters').click(renderResults);
  
  $('#clearFilters').click(function () {
    $('#searchQuery').val('');
    $('#typeFilter').val('');
    $('#minPrice').val('');
    $('#maxPrice').val('');
    renderResults();
  });

  // Get search query from URL
  const params = new URLSearchParams(window.location.search);
  const q = params.get("q");
  if (q) {
    $('#searchQuery').val(q);
  }

  // Fetch and render products on page load
  fetchAndRenderResults();

  // Add to Cart function (same as in product-detail.js)
  function addToCart(productId, quantity) {
    $.ajax({
      url: '../backend/controllers/cart.php',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({ product_id: productId, quantity }),
      success: function (res) {
        alert(res.status === 'success' ? 'Added to cart!' : res.message);
      },
      error: function () {
        alert('Error adding to cart.');
      }
    });
  }
});
