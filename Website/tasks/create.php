<?php
global $conn, $taskId;
require __DIR__ . "/../backend/conn.php";

$query = "SELECT * FROM sections";
$statement = $conn->prepare($query);
$statement->execute();
$sections = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="create">
    <h1>Taak toevoegen</h1>
    <p>Voeg met het onderstaande formulier een nieuwe taak toe</p>

    <form action="../backend/Controllers/tasksController.php" method="POST">
        <div class="create-form-group">
            <label for="title">Titel</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="create-form-group">
            <label for="description">Beschrijving</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div class="create-form-group">
            <label for="section">Afdeling</label>
            <select name="section" id="section">
                <?php foreach ($sections as $section): ?>
                    <option value="<?php echo $section['id']; ?>"><?php echo $section['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="create-form-group">
            <label for="deadline">Deadline</label>
            <input type="date" id="deadline" name="deadline" required>
        </div>

        <input type="hidden" name="status" value="todo">
        <input type="hidden" name="action" value="create">

        <input type="submit" value="Voeg Taak toe">
    </form>
</div>
