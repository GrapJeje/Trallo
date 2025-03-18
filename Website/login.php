<!doctype html>
<html lang="nl">

<head>
    <?php require_once "layout/head.php"; ?>
    <title>Trallo | Login</title>
    <link rel="stylesheet" href="public/css/main.css">
</head>

<body>
    <?php require_once 'layout/header.php' ?>
    <form action="backend/Controllers/loginController.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="User@mail.com" required>
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <input type="submit" value="login">
    </form>

    <?php if (isset($_GET['msg'])): ?>
        <p><?php echo $_GET['msg']; ?></p>
    <?php endif; ?>
    <?php require_once 'layout/footer.php' ?>
</body>

</html>