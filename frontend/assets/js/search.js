function renderStars(rating) {
  return Array.from({ length: 5 }, (_, i) =>
    `<span class="text-warning">${i < rating ? "★" : "☆"}</span>`
  ).join('');
}

// Get the current value of the search input
function getSearchQuery() {
  const input = document.getElementById("searchQuery");
  return input ? input.value.trim().toLowerCase() : "";
}

// Read filter values from the UI
function getFilters() {
  return {
    type: document.getElementById("typeFilter").value.trim().toLowerCase(),
    minPrice: parseFloat(document.getElementById("minPrice").value) || 0,
    maxPrice: parseFloat(document.getElementById("maxPrice").value) || Infinity
  };
}

let allProducts = [];

// Display filtered products
function renderResults() {
  const query = getSearchQuery();
  const { type, minPrice, maxPrice } = getFilters();
  const container = document.getElementById("search-results");

  const matches = allProducts.filter(p => {
    const nameMatch = p.name?.toLowerCase().includes(query);
    const descMatch = p.description?.toLowerCase().includes(query);
    const productType = (p.type || "").toLowerCase();
    const priceMatch = p.price >= minPrice && p.price <= maxPrice;
    const typeMatch = type === "" || productType === type;

    return (nameMatch || descMatch) && priceMatch && typeMatch;
  });

  document.getElementById("result-count").textContent =
    `${matches.length} result(s) found for "${query}"`;

  if (matches.length === 0) {
    container.innerHTML = "<p>No products found.</p>";
    return;
  }

  container.innerHTML = matches.map(p => `
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
            <button class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation(); addToCart(${p.id}, document.getElementById('qty-${p.id}').value)">
              <i class="fas fa-cart-plus"></i> Add
            </button>
          </div>
        </div>
      </div>
    </div>
  `).join('');
}

// Fetch product data from backend
async function fetchAndRenderResults() {
  const res = await fetch("../backend/controllers/products.php?_=" + new Date().getTime()); // Prevent caching
  allProducts = await res.json();
  renderResults();
}

document.addEventListener("DOMContentLoaded", () => {
  fetchAndRenderResults();

  document.getElementById("applyFilters").addEventListener("click", renderResults);

  // Clear all filters
  document.getElementById("clearFilters").addEventListener("click", () => {
    document.getElementById("searchQuery").value = "";
    document.getElementById("typeFilter").value = "";
    document.getElementById("minPrice").value = "";
    document.getElementById("maxPrice").value = "";
    renderResults();
  });

  const params = new URLSearchParams(window.location.search);
  const q = params.get("q");
  if (q) {
    document.getElementById("searchQuery").value = q;
  }
});

// copied from product-detail.js
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
