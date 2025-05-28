// Load HTML components dynamically
async function loadComponent(id, url) {
  const res = await fetch(url);
  const html = await res.text();
  document.getElementById(id).innerHTML = html;
}

loadComponent("topbar", "components/topbar.html");
loadComponent("footer", "components/footer.html");

// Utility function to split an array into chunks
function chunkArray(arr, chunkSize) {
  const chunks = [];
  for (let i = 0; i < arr.length; i += chunkSize) {
    chunks.push(arr.slice(i, i + chunkSize));
  }
  return chunks;
}

// Load product data and render it into the homepage
async function loadProducts() {
  const res = await fetch("../backend/controllers/products.php");
  const products = await res.json();

  const categories = {
    football: [],
    tennis: [],
    badminton: []
  };

  const keywords = {
    football: ["shoe", "boot", "cleat"],
    tennis: ["tennis"],
    badminton: ["badminton", "feather"]
  };

  // Classify products into categories based on keywords
  for (const product of products) {
    for (const cat in keywords) {
      if (categories[cat].length >= 4) continue; // limit to 4 products per category
      if (keywords[cat].some(keyword => product.name.toLowerCase().includes(keyword))) {
        categories[cat].push(product);
        break;
      }
    }
  }

  // Render each category with rows containing up to 4 products
  for (const cat in categories) {
    const container = document.getElementById(`${cat}-products`);
    const rows = chunkArray(categories[cat], 4);

    for (const row of rows) {
      let rowHTML = `<div class="row">`;
      for (const product of row) {
        rowHTML += `
          <div class="col-md-3 mb-4">
            <div class="card product-card" onclick="window.location.href='product-detail.html?id=${product.id}'">
              <img src="${product.image}" class="card-img-top" alt="${product.name}">
              <div class="card-body">
                <h5 class="card-title fw-bold">${product.name}</h5>
                <p class="card-text text-warning">${renderStars(product.rating)}</p>
                <p class="card-text text-primary">$${product.price}</p>
              </div>
            </div>
          </div>
        `;
      }
      rowHTML += `</div>`;
      container.innerHTML += rowHTML;
    }
  }
}

// Generate star rating in HTML
function renderStars(rating) {
  let stars = "";
  for (let i = 1; i <= 5; i++) {
    stars += `<span class="text-warning">${i <= rating ? "★" : "☆"}</span>`;
  }
  return stars;
}

loadProducts();
