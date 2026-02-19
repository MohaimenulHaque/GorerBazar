    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-column">
                        <h3><?php echo getSetting('site_name'); ?></h3>
                        <p>Your trusted online grocery store in Bangladesh. We deliver fresh vegetables, fruits, meat, and daily essentials right to your doorstep.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    
                    <div class="footer-column">
                        <h4>Quick Links</h4>
                        <ul class="footer-links">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="products.php">All Products</a></li>
                            <li><a href="contact.php">Contact Us</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h4>Categories</h4>
                        <ul class="footer-links">
                            <?php
                            $footerCats = getAllCategories();
                            foreach($footerCats as $cat):
                            ?>
                            <li><a href="category.php?slug=<?php echo $cat['slug']; ?>"><?php echo $cat['name']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h4>Contact Info</h4>
                        <ul class="contact-info">
                            <li><i class="fas fa-map-marker-alt"></i> <?php echo getSetting('site_address'); ?></li>
                            <li><i class="fas fa-phone"></i> <?php echo getSetting('site_phone'); ?></li>
                            <li><i class="fas fa-envelope"></i> <?php echo getSetting('site_email'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> <?php echo getSetting('site_name'); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Quick View Modal -->
    <div class="modal quick-view-modal">
        <div class="modal-content">
            <button class="close-modal"><i class="fas fa-times"></i></button>
            <div class="quick-view-content">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notification">
        <i class="fas fa-check-circle"></i>
        <span class="toast-message">Product added to cart!</span>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <?php if(isset($additionalJS)) echo $additionalJS; ?>
</body>
</html>
