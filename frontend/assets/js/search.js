function renderStars(rating) {
  return Array.from({ length: 5 }, (_, i) =>
    `<span class="text-warning">${i < rating ? "★" : "☆"}</span>`
  ).join('');
}

function getSearchQuery() {
  const params = new URLSearchParams(window.location.search);
  return params.get("q") || "";
}

async function fetchAndRenderResults() {
  const query = getSearchQuery().toLowerCase();
  const res = await fetch("../backend/controllers/products.php");
  const products = await res.json();
  const container = document.getElementById("search-results");

  const matches = products.filter(p =>
    p.name.toLowerCase().includes(query) ||
    p.description.toLowerCase().includes(query)
  );

  document.getElementById("result-count").textContent = `${matches.length} result(s) found for "${query}"`;

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
            <input type="number" class="form-control form-control-sm" id="qty-${p.id}" value="1" min="1" style="width: 60px;">
            <button class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation(); addToCart(${p.id}, document.getElementById('qty-${p.id}').value)">
              <i class="fas fa-cart-plus"></i> Add
            </button>
          </div>
        </div>
      </div>
    </div>
  `).join('');
}

document.addEventListener("DOMContentLoaded", fetchAndRenderResults);
