CREATE DATABASE mvc_app;
USE mvc_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100),
    stock_quantity INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, phone, status) VALUES
('John Doe', 'john@example.com', '+1234567890', 'active'),
('Jane Smith', 'jane@example.com', '+1234567891', 'active'),
('Mike Johnson', 'mike@example.com', '+1234567892', 'inactive'),
('Sarah Wilson', 'sarah@example.com', '+1234567893', 'active');

INSERT INTO products (name, description, price, category, stock_quantity) VALUES
('Laptop', 'High-performance laptop', 999.99, 'Electronics', 15),
('Smartphone', 'Latest smartphone model', 699.99, 'Electronics', 30),
('Office Chair', 'Ergonomic office chair', 199.99, 'Furniture', 25),
('Desk Lamp', 'LED desk lamp', 49.99, 'Home', 50);