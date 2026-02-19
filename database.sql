-- Database Schema for Ghorer Bazar E-commerce

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    parent_id INT DEFAULT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    short_description VARCHAR(500),
    price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2),
    sku VARCHAR(100),
    image VARCHAR(255),
    images TEXT,
    category_id INT,
    stock INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    featured ENUM('yes', 'no') DEFAULT 'no',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Customers Table
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT,
    city VARCHAR(100),
    postal_code VARCHAR(20),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    shipping_cost DECIMAL(10,2) DEFAULT 0,
    total DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_name VARCHAR(255),
    shipping_phone VARCHAR(20),
    shipping_address TEXT,
    shipping_city VARCHAR(100),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
);

-- Order Items Table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NULL,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- Admin Users Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    role ENUM('admin', 'editor') DEFAULT 'admin',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Site Settings Table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT
);

-- Insert default admin (password: admin123)
INSERT INTO admins (username, email, password, name) VALUES 
('admin', 'admin@ghorer.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator');

-- Insert default settings
INSERT INTO settings (setting_key, setting_value) VALUES 
('site_name', 'Ghorer Bazar'),
('site_logo', ''),
('site_email', 'info@ghorerbazar.com'),
('site_phone', '+880 1234 567890'),
('site_address', ' Dhaka, Bangladesh'),
('currency', 'BDT'),
('shipping_cost', '60');

-- Insert sample categories
INSERT INTO categories (name, slug, description, image, status) VALUES 
('Fresh Vegetables', 'fresh-vegetables', 'Fresh and organic vegetables', 'vegetables.jpg', 'active'),
('Fresh Fruits', 'fresh-fruits', 'Fresh fruits from local farms', 'fruits.jpg', 'active'),
('Meat & Fish', 'meat-fish', 'Fresh meat and fish', 'meat.jpg', 'active'),
('Dairy Products', 'dairy-products', 'Milk, cheese, and dairy items', 'dairy.jpg', 'active'),
('Grocery', 'grocery', 'Daily grocery items', 'grocery.jpg', 'active'),
('Beverages', 'beverages', 'Drinks and beverages', 'beverages.jpg', 'active');

-- Insert sample products
INSERT INTO products (name, slug, description, short_description, price, sale_price, sku, image, category_id, stock, status, featured) VALUES
('Fresh Tomato', 'fresh-tomato', 'Fresh organic tomatoes directly from farm', 'Fresh organic tomatoes', 120.00, 99.00, 'TOM-001', 'tomato.jpg', 1, 100, 'active', 'yes'),
('Potato', 'potato', 'Fresh potatoes', 'Fresh local potatoes', 45.00, 35.00, 'POT-001', 'potato.jpg', 1, 200, 'active', 'yes'),
('Onion', 'onion', 'Fresh red onions', 'Fresh red onions', 130.00, 110.00, 'ONI-001', 'onion.jpg', 1, 150, 'active', 'no'),
('Banana', 'banana', 'Fresh ripe bananas', 'Fresh ripe bananas (per dozen)', 60.00, 50.00, 'BAN-001', 'banana.jpg', 2, 100, 'active', 'yes'),
('Apple', 'apple', 'Fresh red apples', 'Imported red apples (per kg)', 350.00, 299.00, 'APP-001', 'apple.jpg', 2, 50, 'active', 'yes'),
('Mango', 'mango', 'Sweet ripe mangoes', 'Sweet ripe mangoes (per kg)', 200.00, 180.00, 'MAN-001', 'mango.jpg', 2, 80, 'active', 'no'),
('Chicken Meat', 'chicken-meat', 'Fresh broiler chicken', 'Fresh broiler chicken (per kg)', 180.00, 160.00, 'CHK-001', 'chicken.jpg', 3, 50, 'active', 'yes'),
('Rohu Fish', 'rohu-fish', 'Fresh rohu fish', 'Fresh rohu fish (per kg)', 450.00, 399.00, 'ROH-001', 'rohu.jpg', 3, 30, 'active', 'no'),
('Milk', 'milk', 'Fresh pasteurized milk', 'Fresh pasteurized milk (1 liter)', 90.00, 80.00, 'MLK-001', 'milk.jpg', 4, 100, 'active', 'yes'),
('Egg', 'egg', 'Fresh farm eggs', 'Fresh farm eggs (per dozen)', 150.00, 130.00, 'EGG-001', 'egg.jpg', 4, 200, 'active', 'yes'),
('Rice', 'rice', 'Premium quality rice', 'Premium basmati rice (per kg)', 120.00, 99.00, 'RIC-001', 'rice.jpg', 5, 100, 'active', 'yes'),
('Sugar', 'sugar', 'Refined sugar', 'Refined sugar (per kg)', 110.00, 95.00, 'SUG-001', 'sugar.jpg', 5, 150, 'active', 'no'),
('Salt', 'salt', 'iodized salt', 'Iodized salt (per kg)', 40.00, 35.00, 'SAL-001', 'salt.jpg', 5, 200, 'active', 'no'),
('Oil', 'oil', 'Pure mustard oil', 'Pure mustard oil (1 liter)', 220.00, 199.00, 'OIL-001', 'oil.jpg', 5, 80, 'active', 'yes'),
('Orange Juice', 'orange-juice', 'Fresh orange juice', 'Fresh orange juice (1 liter)', 250.00, 220.00, 'OJU-001', 'juice.jpg', 6, 50, 'active', 'no'),
('Water Bottle', 'water-bottle', 'Drinking water', 'Drinking water (1.5 liter)', 30.00, 25.00, 'WAT-001', 'water.jpg', 6, 200, 'active', 'no');
