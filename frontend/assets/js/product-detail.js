// Load reusable components
async function loadComponent(id, url) {
    const res = await fetch(url);
    const html = await res.text();
    document.getElementById(id).innerHTML = html;
  }
  
  loadComponent("topbar", "components/topbar.html");
  loadComponent("footer", "components/footer.html");
  
  // Get product ID from query string
  function getProductIdFromURL() {
    const params = new URLSearchParams(window.location.search);
    return params.get("id");
  }
  
  // Render star rating as ★ and ☆
  function renderStars(rating) {
    let stars = "";
    for (let i = 1; i <= 5; i++) {
      stars += `<span class="text-warning">${i <= rating ? "★" : "☆"}</span>`;
    }
    return stars;
  }
  
  // Load product data by ID
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
      } else {
        document.querySelector(".detail-box").innerHTML = "<p>Product not found.</p>";
      }
    } catch (error) {
      console.error("Error loading product:", error);
      document.querySelector(".detail-box").innerHTML = "<p>Error loading product details.</p>";
    }
  }
  
  loadProductDetails();
  
  // Load reviews from server
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
          <strong>${review.username}</strong> <span class="text-muted small">(${new Date(review.created_at).toLocaleDateString()})</span>
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
  
  // Run after DOM content loaded
  document.addEventListener("DOMContentLoaded", () => {
    loadProductDetails();
    loadReviews();
  });
  