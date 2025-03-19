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
</head>

<body>
    <?php require_once '../layout/header.php' ?>

    <main>
        <form action="../backend/Controllers/registerController.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="User@mail.com" required>
            <label for="password">Wachtwoord:</label>
            <input type="password" name="password" placeholder="Wachtwoord" required>
            <label for="second_password">Herhaal wachtwoord:</label>
            <input type="password" name="second_password" placeholder="Wachtwoord" required>
            <input type="submit" value="Register" id="register">
        </form>

        <p>Heb je al een account? Log dan nu in!</p>
        <a href="<?php echo $base_url ?>/login">Log in!</a>

        <?php if (isset($_GET['msg'])): ?>
            <p><?php echo $_GET['msg']; ?></p>
        <?php endif; ?>
    </main>
</body>

</html>