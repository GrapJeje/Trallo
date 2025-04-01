<?php
global $base_url;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../backend/config.php';
?>

<div class="login-container">
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="<?php echo $base_url; ?>/auth/logout.php">Uitloggen</a>
    <?php else: ?>
        <a href="<?php echo $base_url; ?>/login">Inloggen</a>
    <?php endif; ?>
</div>
<div class="register-container">
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="<?php echo $base_url; ?>/tasks">Dashboard</a>
    <?php else : ?>
        <a href="<?php echo $base_url; ?>/register">Register</a>
    <?php endif; ?>
</div>
