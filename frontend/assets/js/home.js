// Load topbar and footer using async/await
async function loadComponent(id, url) {
    const res = await fetch(url);
    const html = await res.text();
    document.getElementById(id).innerHTML = html;
  }
  
  loadComponent("topbar", "components/topbar.html");
  loadComponent("footer", "components/footer.html");
  
  // Sample product data
  const products = {
    football: [
      { id: 1, name: "Football Shoes 1", image: "assets/img/shoe1.png", price: 89.99, rating: 4 },
      { id: 2, name: "Football Shoes 2", image: "assets/img/shoe2.png", price: 99.99, rating: 5 },
      { id: 3, name: "Training Ball", image: "assets/img/banner1.jpeg", price: 39.99, rating: 4 },
      { id: 4, name: "Shin Guards", image: "assets/img/shoe1.png", price: 19.99, rating: 3 }
    ],
    badminton: [
      { id: 5, name: "Racket Pro", image: "assets/img/shoe2.png", price: 59.99, rating: 5 },
      { id: 6, name: "Shuttlecocks", image: "assets/img/banner1.jpeg", price: 12.99, rating: 4 },
      { id: 7, name: "Grip Tape", image: "assets/img/shoe1.png", price: 7.99, rating: 4 },
      { id: 8, name: "Badminton Bag", image: "assets/img/shoe2.png", price: 29.99, rating: 3 }
    ],
    tennis: [
      { id: 9, name: "Tennis Racket", image: "assets/img/banner1.jpeg", price: 109.99, rating: 5 },
      { id: 10, name: "Tennis Balls", image: "assets/img/shoe1.png", price: 14.99, rating: 4 },
      { id: 11, name: "Sweatband Set", image: "assets/img/shoe2.png", price: 9.99, rating: 3 },
      { id: 12, name: "Tennis Shoes", image: "assets/img/shoe1.png", price: 99.99, rating: 5 }
    ]
  };
  
  // Convert rating to star HTML
  function renderStars(rating) {
    let stars = "";
    for (let i = 1; i <= 5; i++) {
      stars += `<span class="text-warning">${i <= rating ? "★" : "☆"}</span>`;
    }
    return stars;
  }
  
  // Load and render product cards dynamically
  async function loadProductCards() {
    const res = await fetch("components/product-card.html");
    const template = await res.text();
  
    for (const category in products) {
      const container = document.getElementById(category + "-products");
      products[category].forEach(product => {
        let card = template
          .replace(/{{id}}/g, product.id)
          .replace("{{name}}", product.name)
          .replace("{{image}}", product.image)
          .replace("{{price}}", product.price)
          .replace("{{stars}}", renderStars(product.rating));
        container.innerHTML += card;
      });
    }
  }
  
  loadProductCards();
  