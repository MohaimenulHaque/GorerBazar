<?php
// session_start();
require_once 'config/database.php';

function getSetting($key) {
    global $conn;
    $stmt = $conn->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()) {
        return $row['setting_value'];
    }
    return '';
}

function getAllCategories() {
    global $conn;
    $result = $conn->query("SELECT * FROM categories WHERE status = 'active' ORDER BY name");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getCategoryBySlug($slug) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM categories WHERE slug = ? AND status = 'active'");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getCategoryById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getProducts($limit = 0, $category_id = null, $featured = null) {
    global $conn;
    $sql = "SELECT * FROM products WHERE status = 'active'";
    
    if($category_id) {
        $sql .= " AND category_id = " . intval($category_id);
    }
    
    if($featured) {
        $sql .= " AND featured = 'yes'";
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    if($limit > 0) {
        $sql .= " LIMIT " . intval($limit);
    }
    
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getProductBySlug($slug) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE slug = ? AND status = 'active'");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getFeaturedProducts($limit = 8) {
    return getProducts($limit, null, 'yes');
}

function searchProducts($query) {
    global $conn;
    $search = "%" . $conn->real_escape_string($query) . "%";
    $stmt = $conn->prepare("SELECT * FROM products WHERE status = 'active' AND (name LIKE ? OR description LIKE ?) ORDER BY created_at DESC");
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function formatPrice($price) {
    return getSetting('currency') . ' ' . number_format($price, 0);
}

function addToCart($product_id, $quantity = 1) {
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if(isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    return array_sum($_SESSION['cart']);
}

function removeFromCart($product_id) {
    if(isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

function getCartItems() {
    global $conn;
    $items = [];
    
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $ids = array_keys($_SESSION['cart']);
        $ids = array_map('intval', $ids);
        $ids = implode(',', $ids);
        
        $result = $conn->query("SELECT * FROM products WHERE id IN ($ids) AND status = 'active'");
        
        while($product = $result->fetch_assoc()) {
            $product['quantity'] = $_SESSION['cart'][$product['id']];
            $product['item_total'] = $product['sale_price'] ? $product['sale_price'] * $product['quantity'] : $product['price'] * $product['quantity'];
            $items[] = $product;
        }
    }
    
    return $items;
}

function getCartTotal() {
    $items = getCartItems();
    $total = 0;
    
    foreach($items as $item) {
        $total += $item['item_total'];
    }
    
    return $total;
}

function getCartCount() {
    if(isset($_SESSION['cart'])) {
        return array_sum($_SESSION['cart']);
    }
    return 0;
}

function generateOrderNumber() {
    return 'GB' . date('Ymd') . rand(1000, 9999);
}

function saveOrder($customer_id, $items, $shipping_info) {
    global $conn;
    
    $subtotal = getCartTotal();
    $shipping_cost = floatval(getSetting('shipping_cost'));
    $total = $subtotal + $shipping_cost;
    $order_number = generateOrderNumber();
    
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, order_number, subtotal, shipping_cost, total, payment_method, shipping_name, shipping_phone, shipping_address, shipping_city, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $payment_method = $shipping_info['payment_method'] ?? 'cod';
    $stmt->bind_param("isddissssss", $customer_id, $order_number, $subtotal, $shipping_cost, $total, $payment_method, $shipping_info['name'], $shipping_info['phone'], $shipping_info['address'], $shipping_info['city'], $shipping_info['notes']);
    
    if($stmt->execute()) {
        $order_id = $conn->insert_id;
        
        foreach($items as $item) {
            $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
            $item_subtotal = $price * $item['quantity'];
            
            $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
            $item_stmt->bind_param("issdii", $order_id, $item['id'], $item['name'], $price, $item['quantity'], $item_subtotal);
            $item_stmt->execute();
        }
        
        unset($_SESSION['cart']);
        return $order_number;
    }
    
    return false;
}

function getCustomerById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getCustomerOrders($customer_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getOrderItems($order_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Admin Functions
function adminLogin($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND status = 'active'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($admin = $result->fetch_assoc()) {
        if(password_verify($password, $admin['password'])) {
            return $admin;
        }
    }
    return false;
}

function getAllOrders($status = null) {
    global $conn;
    $sql = "SELECT o.*, c.name as customer_name, c.phone as customer_phone FROM orders o LEFT JOIN customers c ON o.customer_id = c.id";
    
    if($status) {
        $sql .= " WHERE o.order_status = '" . $conn->real_escape_string($status) . "'";
    }
    
    $sql .= " ORDER BY o.created_at DESC";
    
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function updateOrderStatus($order_id, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    return $stmt->execute();
}

function getAllCustomers() {
    global $conn;
    $result = $conn->query("SELECT * FROM customers ORDER BY created_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function updateSetting($key, $value) {
    global $conn;
    $stmt = $conn->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
    $stmt->bind_param("ss", $value, $key);
    return $stmt->execute();
}
?>
