<?php

global $base_url;
require_once __DIR__ . "/../backend/conn.php";

?>

<header>
    <h1>Trallo<span>Dashboard</span></h1>
    <div>
        <img src="<?php echo $base_url ?>/public/img/logo-big-v4.png" alt="Logo">
    </div>
    <div class="nav-container">
        <div class="login-container">
            <?php require_once __DIR__ . '/../auth/loginHeader.php'; ?>
        </div>
        <div class="register-container">
            <a href="<?php echo $base_url; ?>/register">Register</a>
        </div>
    </div>
</header>