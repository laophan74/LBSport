async function loadComponent(id, url) {
  const res = await fetch(url);
  const html = await res.text();
  document.getElementById(id).innerHTML = html;
}

// split array into chunks
function chunkArray(array, size) {
  const result = [];
  for (let i = 0; i < array.length; i += size) {
    result.push(array.slice(i, i + size));
  }
  return result;
}

function renderStars(rating) {
  return Array.from({ length: 5 }, (_, i) =>
    `<span class="text-warning">${i < rating ? "★" : "☆"}</span>`
  ).join('');
}

// Load and display products
async function loadProducts() {
  const res = await fetch("../backend/controllers/products.php");
  const products = await res.json();

  const football = products.filter(p => p.name.toLowerCase().includes("shoe") || p.name.toLowerCase().includes("boot"));
  const tennis = products.filter(p => p.name.toLowerCase().includes("tennis"));
  const badminton = products.filter(p => p.name.toLowerCase().includes("badminton") || p.name.toLowerCase().includes("feather"));

  renderCategory("football-products", football);
  renderCategory("tennis-products", tennis);
  renderCategory("badminton-products", badminton);
}

// Render a product category into HTML
function renderCategory(containerId, products) {
  const container = document.getElementById(containerId);
  const rows = chunkArray(products.slice(0, 4), 4);

  for (const row of rows) {
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

    container.innerHTML += `<div class="row">${rowHTML}</div>`;
  }
}

loadProducts();
