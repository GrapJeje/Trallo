<?php

global $base_url;
require_once __DIR__ . "/../backend/conn.php";

?>

<header>
    <img src="<?php echo $base_url ?>/public/img/logo-big-v4.png" alt="Logo">
    <h1>Trallo</h1>
    <?php require_once __DIR__ . '/../auth/loginHeader.php'; ?>
</header>