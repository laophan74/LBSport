function renderStars(rating) {
    return Array.from({ length: 5 }, (_, i) =>
      `<span class="text-warning">${i < rating ? "★" : "☆"}</span>`
    ).join('');
  }
  