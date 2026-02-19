<?php
// session_start();
require_once '../inc/adminFunctions.php';

if(!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

function getOrderCount($status = null) {
    global $conn;
    if($status) {
        $result = $conn->query("SELECT COUNT(*) as count FROM orders WHERE order_status = '$status'");
    } else {
        $result = $conn->query("SELECT COUNT(*) as count FROM orders");
    }
    $row = $result->fetch_assoc();
    return $row['count'];
}

function getTotalSales() {
    global $conn;
    $result = $conn->query("SELECT SUM(total) as total FROM orders WHERE order_status = 'delivered'");
    $row = $result->fetch_assoc();
    return $row['total'] ?: 0;
}

$totalOrders = getOrderCount();
$pendingOrders = getOrderCount('pending');
$totalSales = getTotalSales();
$totalProducts = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$totalCustomers = $conn->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: #1a1a1a;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-header {
            padding: 20px;
            background: #fc8934;
            text-align: center;
        }
        .sidebar-header h2 {
            font-size: 22px;
        }
        .sidebar-menu {
            padding: 20px 0;
        }
        .menu-section {
            margin-bottom: 10px;
        }
        .menu-title {
            padding: 10px 20px;
            font-size: 12px;
            text-transform: uppercase;
            color: #888;
        }
        .menu-item {
            display: block;
            padding: 12px 20px;
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s;
        }
        .menu-item:hover, .menu-item.active {
            background: #333;
            color: white;
            border-left: 3px solid #fc8934;
        }
        .menu-item i {
            margin-right: 10px;
            width: 20px;
        }
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
        }
        .top-bar {
            background: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .top-bar h1 {
            font-size: 24px;
            color: #333;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-info span {
            color: #666;
        }
        .logout-btn {
            padding: 8px 15px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #fc8934;
        }
        .stat-card .icon {
            width: 50px;
            height: 50px;
            background: #fff3e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fc8934;
            float: right;
            margin-top: -40px;
        }
        .data-table {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .table-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-header h2 {
            font-size: 18px;
        }
        .btn-add {
            padding: 10px 20px;
            background: #fc8934;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        table th {
            background: #f8f8f8;
            font-weight: 600;
            color: #333;
        }
        table tr:hover {
            background: #fafafa;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .action-btns {
            display: flex;
            gap: 8px;
        }
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-edit { background: #ffc107; color: #000; }
        .btn-delete { background: #dc3545; color: #fff; }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            max-width: 800px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        .btn-submit {
            padding: 12px 30px;
            background: #fc8934;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-shopping-basket"></i><?php echo getSetting('site_name'); ?></h2>
            </div>
            <nav class="sidebar-menu">
                <div class="menu-section">
                    <div class="menu-title">Main</div>
                    <a href="dashboard.php" class="menu-item <?php echo $page == 'dashboard' ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </div>
                
                <div class="menu-section">
                    <div class="menu-title">Management</div>
                    <a href="?page=orders" class="menu-item <?php echo $page == 'orders' ? 'active' : ''; ?>">
                        <i class="fas fa-shopping-cart"></i> Orders
                    </a>
                    <a href="?page=products" class="menu-item <?php echo $page == 'products' ? 'active' : ''; ?>">
                        <i class="fas fa-box"></i> Products
                    </a>
                    <a href="?page=add-product" class="menu-item <?php echo $page == 'add-product' ? 'active' : ''; ?>">
                        <i class="fas fa-plus-circle"></i> Add Product
                    </a>
                    <a href="?page=categories" class="menu-item <?php echo $page == 'categories' ? 'active' : ''; ?>">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                    <a href="?page=customers" class="menu-item <?php echo $page == 'customers' ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i> Customers
                    </a>
                </div>
                
                <div class="menu-section">
                    <div class="menu-title">Settings</div>
                    <a href="?page=settings" class="menu-item <?php echo $page == 'settings' ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i> Site Settings
                    </a>
                </div>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="top-bar">
                <h1><?php echo ucfirst($page); ?></h1>
                <div class="user-info">
                    <span>Welcome, <?php echo $_SESSION['admin_name']; ?></span>
                    <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
            
            <?php
            switch($page) {
                case 'orders':
                    include 'pages/orders.php';
                    break;
                case 'products':
                    include 'pages/products.php';
                    break;
                case 'add-product':
                    include 'pages/add-product.php';
                    break;
                case 'edit-product':
                    include 'pages/edit-product.php';
                    break;
                case 'categories':
                    include 'pages/categories.php';
                    break;
                case 'customers':
                    include 'pages/customers.php';
                    break;
                case 'settings':
                    include 'pages/settings.php';
                    break;
                default:
                    include 'pages/dashboard.php';
            }
            ?>
        </main>
    </div>
</body>
</html>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>