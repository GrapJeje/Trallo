<?php

global $base_url;
require_once __DIR__ . "/../backend/conn.php";

?>

    <header>
        <h1>Trallo<span>Dashboard</span></h1>
        <a href="<?php echo $base_url ?>">
            <img src="<?php echo $base_url ?>/public/img/logo-big-v4.png" alt="Logo">
        </a>
        <div class="nav-container">
            <?php require_once __DIR__ . "/../auth/loginHeader.php"; ?>
        </div>
    </header>

<?php if (isset($_GET['alert'])): ?>
    <div class="notification-banner" id="notificationBanner">
        <div class="notification-content">
            <?php echo $_GET['alert']; ?>
        </div>
        <button class="close-button" id="closeButton">&times;</button>
        <script src="<?php echo $base_url ?>/public/js/notification.js"></script>
    </div>
<?php endif ?>