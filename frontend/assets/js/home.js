$(document).ready(function () {
  function loadComponent(id, url) {
    $.get(url, function (html) {
      $(`#${id}`).html(html);
    });
  }

  // Split array into smaller chunks
  function chunkArray(array, size) {
    const result = [];
    for (let i = 0; i < array.length; i += size) {
      result.push(array.slice(i, i + size));
    }
    return result;
  }

  // Render star
  function renderStars(rating) {
    return Array.from({ length: 5 }, (_, i) =>
      `<span class="text-warning">${i < rating ? "★" : "☆"}</span>`
    ).join('');
  }

  // Load product
  function loadProducts() {
    $.get("../backend/controllers/products.php", function (products) {
      // Group using type column from DB
      const football = products.filter(p => p.type === 'football');
      const tennis = products.filter(p => p.type === 'tennis');
      const badminton = products.filter(p => p.type === 'badminton');

      renderCategory("football-products", football);
      renderCategory("tennis-products", tennis);
      renderCategory("badminton-products", badminton);
    });
  }

  // Display a category of products in the container
  function renderCategory(containerId, products) {
    const $container = $(`#${containerId}`);
    const rows = chunkArray(products.slice(0, 4), 4);

    rows.forEach(row => {
      const rowHTML = row.map(product => `
        <div class="col-md-3 mb-4">
          <div class="card product-card" onclick="window.location.href='product-detail.php?id=${product.id}'">
            <img src="${product.image}" class="card-img-top" alt="${product.name}">
            <div class="card-body">
              <h5 class="card-title fw-bold">${product.name}</h5>
              <p class="card-text text-warning">${renderStars(product.rating)}</p>
              <p class="card-text text-primary">$${product.price}</p>
            </div>
          </div>
        </div>
      `).join("");

      $container.append(`<div class="row">${rowHTML}</div>`);
    });
  }

  // Run on page load
  loadProducts();
});
