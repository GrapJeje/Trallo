<?php
global $base_url;
session_start();
require_once __DIR__ . '/../backend/config.php';
?>

<div>
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="<?php echo $base_url; ?>/auth/logout.php">Uitloggen</a>
    <?php else: ?>
        <a href="<?php echo $base_url; ?>/login">Inloggen</a>
    <?php endif; ?>
</div>
