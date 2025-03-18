<h1>Taak toevoegen</h1>
<p>Voeg met het onderstaande formulier een nieuwe taak toe</p>

<form action="../backend/Controllers/tasksController.php" method="POST">
    <label for="title">Titel</label>
    <input type="text" id="title" name="title" required>

    <label for="description">Beschrijving</label>
    <textarea id="description" name="description" required></textarea>

    <label for="section">Afdeling</label>
    <select name="section" id="section">
        <option value="section1">section1</option>
        <option value="section2">section2</option>
        <option value="section3">section3</option>
    </select>

    <!-- Status is op todo bij aanmaken -->
    <input type="hidden" name="status" value="todo">
    <input type="hidden" name="action" value="create">

    <input type="submit" value="Voeg Taak toe" id="create">
</form>