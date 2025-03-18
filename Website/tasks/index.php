 <!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trallo</title>
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/css/tasks/view.css">
    <link rel="stylesheet" href="../public/css/tasks/create.css">
</head>
<body>

<?php
require __DIR__ . "/../backend/conn.php";

global $conn, $base_url;

if (isset($_GET['show']))
{
    $amount = $_GET['show'];
}
else
{
    $amount = 5;
}

$query = "SELECT * FROM planning_board ORDER BY deadline DESC LIMIT $amount";
$statement = $conn->prepare($query);
$statement->execute();

$todos = $statement->fetchAll(PDO::FETCH_ASSOC);

$amountHandler = new AmountHandler();

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
                                    <a href="update.php?id=<?php echo $todo['id']; ?>" class="view-read-update-btn">Aanpassen</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <a href="<?php echo $base_url?>/tasks/?show=<?php echo $amountHandler->getNewAmount($amount); ?>">Show more</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../layout/footer.php'; ?>
</body>
</html>

 <?php

 class AmountHandler
 {
     public function getNewAmount($amount)
     {
         require __DIR__ . "/../backend/conn.php";
         global $conn;

         $query = "SELECT * FROM planning_board";
         $statement = $conn->prepare($query);
         $statement->execute();

         $todos = $statement->fetchAll(PDO::FETCH_ASSOC);

         $maxAmount = count($todos);

         $amount += 5;
         if ($amount > $maxAmount) {
             $amount = $maxAmount;
         }

         return $amount;
     }
 }
 ?>