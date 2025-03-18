<!doctype html>
<html lang="nl">

<head>
    <?php require_once "layout/head.php"; ?>
    <title>Trallo | Register</title>
    <link rel="stylesheet" href="public/css/main.css">
</head>

<body>
    <form action="backend/Controllers/registerController.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="User@mail.com" required>
        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <label for="second_password">Herhaal wachtwoord:</label>
        <input type="password" name="second_password" placeholder="Wachtwoord" required>
        <input type="submit" value="Register">
    </form>

    <?php if (isset($_GET['msg'])): ?>
        <p><?php echo $_GET['msg']; ?></p>
    <?php endif; ?>

</body>

</html>