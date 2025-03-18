<!doctype html>
<html lang="nl">
<head>
    <?php require_once "../layout/head.php"; ?>
    <title>Trallo | Update Task</title>
    <link rel="stylesheet" href="../public/css/tasks/update.css">
    <link rel="stylesheet" href="../public/css/main.css">
</head>
<body>

<?php
session_start();
require __DIR__ . "/../backend/conn.php";

global $conn, $base_url;

$query = "SELECT * FROM planning_board";
$statement = $conn->prepare($query);
$statement->execute();

$todos = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="view-container">
        <div class="view-child">
            <div class="view-update">
                <h1>Taak aanpassen</h1>

                <?php
                if (!isset($_SESSION['user_id'])) {
                    echo "<p>Je moet ingelogd zijn om taken te bekijken.</p>";
                    exit();
                }

                $userId = $_SESSION['user_id'];

                if (!isset($_GET['id'])) {
                    echo "<p>Geen taak gevonden.</p>";
                    exit();
                }

                $taskId = $_GET['id'];

                $query = "SELECT * FROM planning_board WHERE id = :id AND user_id = :user_id";
                $statement = $conn->prepare($query);
                $statement->execute(['id' => $taskId, 'user_id' => $userId]);
                $todo = $statement->fetch(PDO::FETCH_ASSOC);

                if (!$todo) {
                    echo "<p>Geen taak gevonden.</p>";
                } else {
                    ?>
                    <form action="../backend/Controllers/tasksController.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
                        <input type="hidden" name="action" value="update">

                        <div class="form-group">
                            <label for="section-<?php echo $todo['id']; ?>">Section</label>
                            <select id="section-<?php echo $todo['id']; ?>" name="section" required>
                                <option value="To Do" <?php echo $todo['section'] == 'section1' ? 'selected' : ''; ?>>
                                    section1
                                </option>
                                <option value="In Progress" <?php echo $todo['section'] == 'section2' ? 'selected' : ''; ?>>
                                    section2
                                </option>
                                <option value="Done" <?php echo $todo['section'] == 'section3' ? 'selected' : ''; ?>>
                                    section3
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title-<?php echo $todo['id']; ?>">Titel</label>
                            <input type="text" id="title-<?php echo $todo['id']; ?>" name="title"
                                   value="<?php echo htmlspecialchars($todo['title']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description-<?php echo $todo['id']; ?>">Beschrijving</label>
                            <textarea id="description-<?php echo $todo['id']; ?>" name="description"
                                      required><?php echo htmlspecialchars($todo['description']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status-<?php echo $todo['id']; ?>">Status</label>
                            <select id="status-<?php echo $todo['id']; ?>" name="status" required>
                                <option value="To Do" <?php echo $todo['status'] == 'To Do' ? 'selected' : ''; ?>>To
                                    Do
                                </option>
                                <option value="In Progress" <?php echo $todo['status'] == 'In Progress' ? 'selected' : ''; ?>>
                                    In Progress
                                </option>
                                <option value="Done" <?php echo $todo['status'] == 'Done' ? 'selected' : ''; ?>>Done
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="view-update-btn">Opslaan</button>
                        <button type="button" onclick="window.location.href='<?php echo $base_url; ?>/tasks'"
                                class="view-update-btn">
                            Annuleren
                        </button>
                    </form>

                    <form action="../backend/Controllers/tasksController.php" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">

                        <button type="submit" class="view-update-btn">Verwijderen</button>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>