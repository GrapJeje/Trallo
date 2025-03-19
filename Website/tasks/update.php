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
require __DIR__ . "/../backend/conn.php";

global $conn, $base_url;

if ($_SESSION == null) {
    header("Location: $base_url/login?msg=U bent niet ingelogd");
    exit;
}

$query = "SELECT * FROM planning_board";
$statement = $conn->prepare($query);
$statement->execute();

$todos = $statement->fetchAll(PDO::FETCH_ASSOC);
require_once '../layout/header.php';
?>

<div class="container">
    <div class="view-container">
        <div class="view-child">
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
                <div class="update">
                    <h1>Taak bewerken</h1>
                    <p>Wijzig de taak hieronder</p>

                    <form action="../backend/Controllers/tasksController.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
                        <input type="hidden" name="action" value="update">

                        <div class="update-form-group">
                            <label for="section-<?php echo $todo['id']; ?>">Afdeling</label>
                            <select id="section-<?php echo $todo['id']; ?>" name="section" required>
                                <option value="To Do" <?php echo $todo['section'] == 'section1' ? 'selected' : ''; ?>>
                                    Section 1
                                </option>
                                <option value="In Progress" <?php echo $todo['section'] == 'section2' ? 'selected' : ''; ?>>
                                    Section 2
                                </option>
                                <option value="Done" <?php echo $todo['section'] == 'section3' ? 'selected' : ''; ?>>
                                    Section 3
                                </option>
                            </select>
                        </div>

                        <div class="update-form-group">
                            <label for="title-<?php echo $todo['id']; ?>">Titel</label>
                            <input type="text" id="title-<?php echo $todo['id']; ?>" name="title"
                                   value="<?php echo htmlspecialchars($todo['title']); ?>" required>
                        </div>

                        <div class="update-form-group">
                            <label for="description-<?php echo $todo['id']; ?>">Beschrijving</label>
                            <textarea id="description-<?php echo $todo['id']; ?>" name="description"
                                      required><?php echo htmlspecialchars($todo['description']); ?></textarea>
                        </div>

                        <div class="update-form-group">
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

                        <div class="update-form-group">
                            <label for="deadline-<?php echo $todo['id']; ?>">Deadline</label>
                            <input type="date" id="deadline-<?php echo $todo['id']; ?>" name="deadline"
                                   value="<?php echo htmlspecialchars($todo['deadline']); ?>" required>
                        </div>

                        <button type="submit" class="view-update-btn">Opslaan</button>
                        <button type="button" onclick="window.location.href='<?php echo $base_url; ?>/tasks'"
                                class="view-update-btn">Annuleren
                        </button>
                    </form>

                    <form action="../backend/Controllers/tasksController.php" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">

                        <button type="submit" class="view-update-btn">Verwijderen</button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php require_once '../layout/footer.php'; ?>
</body>
</html>
