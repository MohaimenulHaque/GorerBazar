<?php
require_once 'inc/functions.php';
$pageTitle = 'Contact Us';
require_once 'inc/header.php';

$success = '';

if(isset($_POST['send_message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $success = 'Thank you for contacting us! We will get back to you soon.';
}
?>

<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>Contact Us</h1>
        <p><a href="index.php">Home</a> / Contact</p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section section-padding">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2>Get In Touch</h2>
                <p>Have questions? We'd love to hear from you.</p>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h4>Address</h4>
                        <p><?php echo getSetting('site_address'); ?></p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h4>Phone</h4>
                        <p><?php echo getSetting('site_phone'); ?></p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h4>Email</h4>
                        <p><?php echo getSetting('site_email'); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <h3>Send us a Message</h3>
                
                <?php if($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" rows="5" required></textarea>
                    </div>
                    
                    <button type="submit" name="send_message" class="btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
