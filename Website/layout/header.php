<?php

global $base_url;
require_once __DIR__ . "/../backend/conn.php";

?>

<header>
    <h1>Trallo<span>Dashboard</span></h1>
    <a href="<?php echo $base_url?>">
        <img src="<?php echo $base_url ?>/public/img/logo-big-v4.png" alt="Logo">
    </a>
    <div class="nav-container">
        <?php require_once __DIR__ . "/../auth/loginHeader.php"; ?>
    </div>
</header>