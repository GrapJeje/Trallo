<!doctype html>
<html lang="nl">

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<head>
    <?php require_once "layout/head.php"; ?>
    <title>Trallo</title>
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/home.css">
</head>

<body>
<?php require_once 'layout/header.php' ?>

<main>
    <div class="main-card">
        <img src="public/img/logo-big-v2.png" alt="Developer Land">
        <div class="main-content">
            <p>Heb jij ook altijd last van onduidelijkheid bij taakverdeling in je team?</p>
            <p><strong>Meld je dan nu aan bij Trallo!</strong></p>
            <p>Het takenbord voor handige werkers.</p>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="tasks" class="signup-button">Dashboard</a>
            <?php else: ?>
                <a href="register" class="signup-button">Meld je aan!</a>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once 'layout/footer.php' ?>
</body>

</html>