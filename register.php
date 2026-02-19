<?php
require_once 'inc/functions.php';
$pageTitle = 'Register';
require_once 'inc/header.php';

$error = '';
$success = '';

if(isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        $check = $conn->query("SELECT id FROM customers WHERE email = '$email'");
        if($check->num_rows > 0) {
            $error = 'Email already registered';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $phone, $hashed);
            
            if($stmt->execute()) {
                $success = 'Registration successful! Please login.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<!-- Register Section -->
<section class="auth-section section-padding">
    <div class="container">
        <div class="auth-form-container">
            <h2>Register</h2>
            <p>Create your account and start shopping.</p>
            
            <?php if($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" required>
                </div>
                
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" required>
                </div>
                
                <button type="submit" name="register" class="btn-primary">Register</button>
            </form>
            
            <p class="auth-switch">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
