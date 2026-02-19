<?php
require_once 'inc/functions.php';
$pageTitle = 'Login';
require_once 'inc/header.php';

$error = '';

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ? AND status = 'active'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($customer = $result->fetch_assoc()) {
        if(password_verify($password, $customer['password'])) {
            $_SESSION['customer_id'] = $customer['id'];
            $_SESSION['customer_name'] = $customer['name'];
            
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'my-account.php';
            header("Location: $redirect");
            exit;
        } else {
            $error = 'Invalid password';
        }
    } else {
        $error = 'Email not found';
    }
}
?>

<!-- Login Section -->
<section class="auth-section section-padding">
    <div class="container">
        <div class="auth-form-container">
            <h2>Login</h2>
            <p>Welcome back! Please login to your account.</p>
            
            <?php if($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" name="login" class="btn-primary">Login</button>
            </form>
            
            <p class="auth-switch">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
