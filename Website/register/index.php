<?php
global $base_url;
require_once __DIR__ . '/../backend/conn.php';
?>

<!doctype html>
<html lang="nl">

<head>
    <?php require_once "../layout/head.php"; ?>
    <title>Trallo | Register</title>
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/css/auth.css">
</head>

<body>
<?php require_once '../layout/header.php' ?>

<main class="auth-main">
    <div class="auth-container">
        <div class="auth-image-container">
            <img src="../public/img/auth_banner.png" alt="Register" class="auth-image">
        </div>

        <div class="auth-form-container">
            <div class="auth-form-wrapper">
                <h1 class="auth-title">Account aanmaken</h1>

                <form action="../backend/Controllers/registerController.php" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" placeholder="user@voorbeeld.com" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Wachtwoord</label>
                        <input type="password" name="password" placeholder="••••••••" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="second_password" class="form-label">Herhaal wachtwoord</label>
                        <input type="password" name="second_password" placeholder="••••••••" class="form-input" required>
                    </div>

                    <button type="submit" class="auth-button">Registreren</button>
                </form>

                <div class="auth-alternative">
                    <p>Heb je al een account?</p>
                    <a href="<?php echo $base_url ?>/login" class="auth-link">Inloggen</a>
                </div>

                <?php if (isset($_GET['msg'])): ?>
                    <div class="auth-message">
                        <?php echo $_GET['msg']; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once '../layout/footer.php' ?>
</body>

</html>