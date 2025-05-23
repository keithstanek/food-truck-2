-- Users table (Firebase auth)
CREATE TABLE users (
    id VARCHAR(64) PRIMARY KEY,
    provider ENUM('google', 'microsoft', 'apple') NOT NULL,
    firebase_uid VARCHAR(128) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- User Settings
CREATE TABLE user_settings (
    user_id VARCHAR(64) PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Franchise
CREATE TABLE franchises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    headquarters VARCHAR(255) NOT NULL
);

-- Restaurants
CREATE TABLE restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    franchise_id INT,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    hours JSON,
    FOREIGN KEY (franchise_id) REFERENCES franchises(id)
);

-- Employees
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT,
    name VARCHAR(100),
    email VARCHAR(100),
    password_hash VARCHAR(255),
    role ENUM('admin', 'manager', 'staff'),
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id)
);

-- Menu Categories
CREATE TABLE menu_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

-- Menu Items
CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT,
    category_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(8,2) NOT NULL,
    image_url VARCHAR(255),
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id),
    FOREIGN KEY (category_id) REFERENCES menu_categories(id)
);

-- Condiments
CREATE TABLE condiments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

-- Menu Item Condiments (many-to-many)
CREATE TABLE menu_item_condiments (
    menu_item_id INT,
    condiment_id INT,
    PRIMARY KEY (menu_item_id, condiment_id),
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id),
    FOREIGN KEY (condiment_id) REFERENCES condiments(id)
);

-- Upgrades
CREATE TABLE upgrades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(8,2) NOT NULL
);

-- Menu Item Upgrades (many-to-many)
CREATE TABLE menu_item_upgrades (
    menu_item_id INT,
    upgrade_id INT,
    PRIMARY KEY (menu_item_id, upgrade_id),
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id),
    FOREIGN KEY (upgrade_id) REFERENCES upgrades(id)
);

-- Orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(64),
    restaurant_id INT,
    status ENUM('ordered', 'picked_up', 'cooking', 'ready', 'delivered', 'completed', 'cancelled') DEFAULT 'ordered',
    total DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id)
);

-- Order Status History
CREATE TABLE order_status_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    status ENUM('ordered', 'picked_up', 'cooking', 'ready', 'delivered', 'completed', 'cancelled'),
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Order Items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    menu_item_id INT,
    quantity INT,
    price DECIMAL(8,2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id)
);

-- Order Item Condiments
CREATE TABLE order_item_condiments (
    order_item_id INT,
    condiment_id INT,
    PRIMARY KEY (order_item_id, condiment_id),
    FOREIGN KEY (order_item_id) REFERENCES order_items(id),
    FOREIGN KEY (condiment_id) REFERENCES condiments(id)
);

-- Order Item Upgrades
CREATE TABLE order_item_upgrades (
    order_item_id INT,
    upgrade_id INT,
    PRIMARY KEY (order_item_id, upgrade_id),
    FOREIGN KEY (order_item_id) REFERENCES order_items(id),
    FOREIGN KEY (upgrade_id) REFERENCES upgrades(id)
);

-- Loyalty Points
CREATE TABLE loyalty_points (
    user_id VARCHAR(64) PRIMARY KEY,
    points INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Coupons
CREATE TABLE coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    description VARCHAR(255),
    discount_type ENUM('percent', 'amount'),
    discount_value DECIMAL(8,2),
    expires_at TIMESTAMP
);

-- Promo Codes
CREATE TABLE promo_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    description VARCHAR(255),
    discount_type ENUM('percent', 'amount'),
    discount_value DECIMAL(8,2),
    expires_at TIMESTAMP
);

-- User Coupons
CREATE TABLE user_coupons (
    user_id VARCHAR(64),
    coupon_id INT,
    used BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (user_id, coupon_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (coupon_id) REFERENCES coupons(id)
);

-- User Promo Codes
CREATE TABLE user_promo_codes (
    user_id VARCHAR(64),
    promo_code_id INT,
    used BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (user_id, promo_code_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (promo_code_id) REFERENCES promo_codes(id)
);

-- Favorites
CREATE TABLE favorite_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(64),
    order_id INT,
    name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- User Themes
CREATE TABLE user_themes (
    user_id VARCHAR(64) PRIMARY KEY,
    theme_json JSON,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(64),
    message TEXT,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);