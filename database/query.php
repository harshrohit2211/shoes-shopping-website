CREATE DATABASE shoe_store;
USE shoestore;

CREATE TABLE users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    address VARCHAR(200),
    role VARCHAR(20) DEFAULT 'Customer',
    PRIMARY KEY (user_id),
    UNIQUE (email)
);

CREATE TABLE products (
    product_id INT(11) NOT NULL AUTO_INCREMENT,
    product_name VARCHAR(100) NOT NULL,
    description TEXT,

    price DECIMAL(10,2) NOT NULL,
    stock INT(11) NOT NULL,

    color VARCHAR(50),
    size VARCHAR(50),

    shoe_type VARCHAR(50) NOT NULL,   -- Partywear, Casual, Sports, Formal

    image1 VARCHAR(255) NOT NULL,
    image2 VARCHAR(255),
    image3 VARCHAR(255),
    image4 VARCHAR(255),

    category_id INT(11) NOT NULL,

    PRIMARY KEY (product_id),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

ALTER TABLE products 
ADD discount INT(3) DEFAULT 0 AFTER price;

INSERT INTO products 
(product_name, description, price, stock, color, size,shoe_type,image1, image2, image3, image4, category_id)
VALUES
(
  'Nike Air Max 270',
  'Lightweight running shoes with breathable mesh and air cushioning.',
  8999,
  25,
  'Black,White,Red',
  '6,7,8,9,10',
  'Partywear',
  'banner.jpeg',
  'login_bg.png',
  'login_box.jpg',
  'shoe2.jpg',
  1
);

INSERT INTO categories (category_name, description)
VALUES
('Men Shoes', 'Shoes for men');

CREATE TABLE categories (
    category_id INT(11) NOT NULL AUTO_INCREMENT,
    category_name VARCHAR(100) NOT NULL,
    description TEXT,
    PRIMARY KEY (category_id)
);

CREATE TABLE orders (
    order_id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    PRIMARY KEY (order_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE order_details (
    orderdetail_id INT(11) NOT NULL AUTO_INCREMENT,
    order_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,

    color VARCHAR(50) NOT NULL,
    size VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,

    quantity INT(11) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,

    PRIMARY KEY (orderdetail_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);
/* ===============================
   CONTACT MESSAGES TABLE
=================================*/
CREATE TABLE contact_messages (
    contact_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

