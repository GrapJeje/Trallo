<!doctype html>
<html lang="nl">

<head>
    <?php require_once "../layout/head.php"; ?>
    <title>Trallo</title>
    <link rel="stylesheet" href="../public/css/tasks/view.css">
    <link rel="stylesheet" href="../public/css/main.css">
</head>

<body>

    <?php
    require __DIR__ . "/../backend/conn.php";

    global $conn;

    $query = "SELECT * FROM planning_board";
    $statement = $conn->prepare($query);
    $statement->execute();

    $todos = $statement->fetchAll(PDO::FETCH_ASSOC);

    require_once '../layout/header.php';
    ?>

    <div class="container">
        <div class="view-container">

            <div class="view-child">
                <?php require_once 'create.php'; ?>
            </div>

            <div class="view-child">
                <div class="view-read">
                    <h1>Taken</h1>

                    <?php
                    // Filter todos by user_id
                    $filteredTodos = array_filter($todos, function ($todo) {
                        return $todo['user_id'] == $_SESSION['user_id'];
                    });

                    if (empty($filteredTodos)):
                        ?>
                        <p>Geen taken gevonden</p>
                    <?php else: ?>
                        <?php foreach ($filteredTodos as $todo): ?>
                            <div class="view-read-card">
                                <p class="view-read-organisatie"><?php echo $todo['section']; ?></p>
                                <div class="view-read-card-container">
                                    <p class="view-read-title"><?php echo $todo['title']; ?></p>
                                    <p class="view-read-description"><?php echo $todo['description']; ?></p>
                                    <div class="view-read-under">
                                        <p class="view-read-status"><?php echo $todo['status']; ?></p>
                                        <a href="update.php?id=<?php echo $todo['id']; ?>"
                                            class="view-read-update-btn">Aanpassen</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php require_once '../layout/footer.php'; ?>
</body>

</html>