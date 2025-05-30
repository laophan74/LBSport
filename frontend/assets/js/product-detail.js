async function loadComponent(id, url) {
  const res = await fetch(url);
  const html = await res.text();
  document.getElementById(id).innerHTML = html;
}

loadComponent("topbar", "components/topbar.html");
loadComponent("footer", "components/footer.html");

function getProductIdFromURL() {
  const params = new URLSearchParams(window.location.search);
  return params.get("id");
}

function renderStars(rating) {
  return Array.from({ length: 5 }, (_, i) =>
    `<span class="text-warning">${i < rating ? "★" : "☆"}</span>`
  ).join('');
}

async function loadProductDetails() {
  const productId = getProductIdFromURL();
  if (!productId) return;

  try {
    const res = await fetch(`../backend/controllers/products.php?id=${productId}`);
    const product = await res.json();

    if (product) {
      document.getElementById("product-name").textContent = product.name;
      document.getElementById("product-image").src = product.image;
      document.getElementById("product-price").textContent = `$${product.price}`;
      document.getElementById("product-rating").innerHTML = renderStars(product.rating);
      document.getElementById("product-description").textContent = product.description;

      document.getElementById("addToCartBtn").addEventListener("click", () => {
        const quantity = parseInt(document.getElementById("quantity").value) || 1;
        addToCart(product.id, quantity);
      });

    } else {
      document.querySelector(".detail-box").innerHTML = "<p>Product not found.</p>";
    }

  } catch (error) {
    console.error("Error loading product:", error);
    document.querySelector(".detail-box").innerHTML = "<p>Error loading product details.</p>";
  }
}

async function loadReviews() {
  const productId = getProductIdFromURL();
  if (!productId) return;

  try {
    const res = await fetch(`../backend/controllers/reviews.php?product_id=${productId}`);
    const reviews = await res.json();
    const reviewList = document.getElementById("review-list");
    reviewList.innerHTML = "";

    if (reviews.length === 0) {
      reviewList.innerHTML = "<p>No reviews yet.</p>";
      return;
    }

    reviews.forEach(review => {
      const item = document.createElement("div");
      item.className = "review-item";
      item.innerHTML = `
        <strong>${review.username}</strong>
        <span class="text-muted small">(${new Date(review.created_at).toLocaleDateString()})</span>
        <div class="text-warning mb-1">${renderStars(review.rating)}</div>
        <p>${review.comment}</p>
      `;
      reviewList.appendChild(item);
    });

  } catch (error) {
    console.error("Error loading reviews:", error);
    document.getElementById("review-list").innerHTML = "<p>Error loading reviews.</p>";
  }
}

async function addToCart(productId, quantity) {
  const res = await fetch("../backend/controllers/cart.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      product_id: productId,
      quantity: quantity,
      username: "admin"
    })
  });

  const result = await res.json();
  if (result.status === "success") {
    alert("Added to cart!");
  } else {
    alert("Failed: " + result.message);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  loadProductDetails();
  loadReviews();
});
