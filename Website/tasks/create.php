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
                <option value="section1">Section 1</option>
                <option value="section2">Section 2</option>
                <option value="section3">Section 3</option>
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