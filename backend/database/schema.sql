-- I've already created tables Bob, don't do that again
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(100),
  role ENUM('customer', 'admin') DEFAULT 'customer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  image VARCHAR(255),
  price DECIMAL(10,2) NOT NULL,
  rating INT DEFAULT 0,
  description TEXT
);


CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  user_id INT,
  rating INT CHECK (rating BETWEEN 1 AND 5),
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Sample
INSERT INTO users (username, password, email, role) VALUES
('admin', SHA2('admin123', 256), 'admin@lbsport.com', 'admin'),
('john', SHA2('johnpass', 256), 'john@example.com', 'customer');

INSERT INTO products (name, image, price, rating, description) VALUES
('Football Shoes 1', 'assets/img/shoe1.png', 89.99, 4, 'Comfortable football shoes.'),
('Football Shoes 2', 'assets/img/shoe2.png', 99.99, 5, 'High-performance football gear.'),
('Training Ball', 'assets/img/banner1.jpeg', 39.99, 4, 'Official size training ball.');
