<?php
if(isset($_POST['save_settings'])) {
    $site_name = $_POST['site_name'];
    $site_email = $_POST['site_email'];
    $site_phone = $_POST['site_phone'];
    $site_address = $_POST['site_address'];
    $currency = $_POST['currency'];
    $shipping_cost = $_POST['shipping_cost'];
    
    updateSetting('site_name', $site_name);
    updateSetting('site_email', $site_email);
    updateSetting('site_phone', $site_phone);
    updateSetting('site_address', $site_address);
    updateSetting('currency', $currency);
    updateSetting('shipping_cost', $shipping_cost);
    
    echo '<div class="alert alert-success">Settings saved successfully!</div>';
}
?>

<div class="form-container">
    <h2 style="margin-bottom: 25px;">Site Settings</h2>
    
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label>Site Name</label>
                <input type="text" name="site_name" value="<?php echo getSetting('site_name'); ?>">
            </div>
            <div class="form-group">
                <label>Currency Symbol</label>
                <input type="text" name="currency" value="<?php echo getSetting('currency'); ?>">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="site_email" value="<?php echo getSetting('site_email'); ?>">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="site_phone" value="<?php echo getSetting('site_phone'); ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label>Address</label>
            <textarea name="site_address"><?php echo getSetting('site_address'); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Shipping Cost</label>
            <input type="number" name="shipping_cost" value="<?php echo getSetting('shipping_cost'); ?>">
        </div>
        
        <button type="submit" name="save_settings" class="btn-submit">Save Settings</button>
    </form>
</div>
