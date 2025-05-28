// Load topbar and footer dynamically from components
fetch("components/topbar.html")
  .then(res => res.text())
  .then(data => document.getElementById("topbar").innerHTML = data);

fetch("components/footer.html")
  .then(res => res.text())
  .then(data => document.getElementById("footer").innerHTML = data);

// Optional: Future code for loading product list dynamically via AJAX can go here
