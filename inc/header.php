<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?><?php echo getSetting('site_name'); ?></title>
    <meta name="description" content="Ghorer Bazar - Your Online Grocery Store">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <?php if(isset($additionalCSS)) echo $additionalCSS; ?>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="top-bar-left">
                    <span><i class="fas fa-phone"></i> <?php echo getSetting('site_phone'); ?></span>
                    <span><i class="fas fa-envelope"></i> <?php echo getSetting('site_email'); ?></span>
                </div>
                <div class="top-bar-right">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php">
                        <h1><?php echo getSetting('site_name'); ?></h1>
                    </a>
                </div>
                
                <div class="search-box">
                    <form action="search.php" method="GET">
                        <input type="text" name="q" placeholder="Search products...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                
                <div class="header-actions">
                    <a href="cart.php" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?></span>
                    </a>
                    <?php if(isLoggedIn()): ?>
                        <a href="my-account.php" class="user-icon">
                            <i class="fas fa-user"></i>
                        </a>
                        <a href="logout.php" class="btn-logout">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn-login">Login</a>
                        <a href="register.php" class="btn-register">Register</a>
                    <?php endif; ?>
                </div>
                
                <button class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="main-nav">
        <div class="container">
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">All Products</a></li>
                <?php
                $categories = getAllCategories();
                foreach($categories as $cat):
                ?>
                <li><a href="category.php?slug=<?php echo $cat['slug']; ?>"><?php echo $cat['name']; ?></a></li>
                <?php endforeach; ?>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <h2><?php echo getSetting('site_name'); ?></h2>
            <button class="close-menu"><i class="fas fa-times"></i></button>
        </div>
        <ul class="mobile-nav-menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">All Products</a></li>
            <?php
            foreach($categories as $cat):
            ?>
            <li><a href="category.php?slug=<?php echo $cat['slug']; ?>"><?php echo $cat['name']; ?></a></li>
            <?php endforeach; ?>
            <li><a href="contact.php">Contact</a></li>
            <?php if(isLoggedIn()): ?>
            <li><a href="my-account.php">My Account</a></li>
            <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="overlay"></div>

    <!-- Main Content -->
    <main>
