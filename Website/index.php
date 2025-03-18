<!doctype html>
<html lang="nl">

<head>
    <?php require_once "layout/head.php"; ?>
    <title>Trallo</title>
    <link rel="stylesheet" href="public/css/main.css">
</head>

<body>
    <?php require_once 'layout/header.php'; ?>

    <?php if (isset($_GET['msg'])): ?>
        <p><?php echo $_GET['msg']; ?></p>
    <?php endif; ?>
    <?php require_once 'layout/footer.php' ?>
</body>

</html>