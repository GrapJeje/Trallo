<!doctype html>
<html lang="nl">

<head>
    <?php

    require_once __DIR__ . '/../backend/Handlers/AmountHandler.php';
    use Website\backend\Handlers\AmountHandler;

    require_once "../layout/head.php"; ?>
    <title>Trallo | Taken</title>
    <link rel="stylesheet" href="../public/css/tasks/view.css">
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/css/tasks/create.css">
</head>

<body>

<?php
require __DIR__ . "/../backend/conn.php";

global $conn, $base_url;

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: $base_url/login?msg=U bent niet ingelogd");
    exit();
}

if (isset($_GET['show'])) {
    $amount = $_GET['show'];
} else {
    $amount = 5;
}

$title = isset($_GET['name']) ? trim($_GET['name']) : '';
$organization = isset($_GET['organization']) ? trim($_GET['organization']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : '';
$deadline = isset($_GET['deadline']) ? trim($_GET['deadline']) : 'desc';

$query = "SELECT * FROM planning_board WHERE user_id = :user_id";

if (!empty($title)) $query .= " AND title LIKE :title";
if (!empty($organization)) $query .= " AND section = :organization";
if (!empty($status)) $query .= " AND status = :status";

if (!empty($deadline)) {
    if ($deadline === 'asc') {
        $query .= " ORDER BY deadline ASC";
    } else {
        $query .= " ORDER BY deadline DESC";
    }
} else {
    $query .= " ORDER BY deadline DESC";
}

$query .= " LIMIT :amount";

$statement = $conn->prepare($query);

$statement->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

if (!empty($title)) $statement->bindValue(':title', '%' . $title . '%');
if (!empty($organization)) $statement->bindValue(':organization', $organization);
if (!empty($status)) $statement->bindValue(':status', $status);
$statement->bindValue(':amount', $amount, PDO::PARAM_INT);

$statement->execute();
$todos = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM sections";
$statement = $conn->prepare($query);
$statement->execute();
$sections = $statement->fetchAll(PDO::FETCH_ASSOC);

$amountHandler = new AmountHandler();

require_once '../layout/header.php';
?>

<div class="container">
    <div class="view-container">
        <div class="view-filter">
            <div class="view-filter-container">
                <h1>Filter</h1>
                <div class="filter-bar">
                    <form method="GET" class="filter-form">
                        <input type="text" name="name" placeholder="Naam" class="filter-input"
                               value="<?php echo htmlspecialchars($title); ?>">
                        <select name="organization" class="filter-select">
                            <option value="">Organisatie</option>
                            <?php foreach ($sections as $section): ?>
                                <option value="<?php echo $section['id']; ?>" <?php echo $organization == $section['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($section['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="status" class="filter-select">
                            <option value="">Status</option>
                            <option value="open" <?php echo $status == 'open' ? 'selected' : ''; ?>>Open</option>
                            <option value="in progress" <?php echo $status == 'in progress' ? 'selected' : ''; ?>>In
                                progress
                            </option>
                            <option value="done" <?php echo $status == 'done' ? 'selected' : ''; ?>>Done</option>
                        </select>

                        <select name="deadline" class="filter-select">
                            <option value="">Deadline</option>
                            <option value="asc" <?php echo $deadline == 'asc' ? 'selected' : ''; ?>>Oudste eerst
                            </option>
                            <option value="desc" <?php echo $deadline == 'desc' ? 'selected' : ''; ?>>Jongste eerst
                            </option>
                        </select>

                        <button type="submit" class="filter-button">Zoeken</button>
                        <a href="<?php echo $base_url; ?>/tasks" class="filter-reset">Reset</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="view-child">
            <?php require_once 'create.php'; ?>
        </div>

        <div class="view-child">
            <div class="view-read">
                <h1>Taken</h1>

                <?php if (empty($todos)): ?>
                    <p class="not-found">Geen taken gevonden</p>
                <?php else:
                    foreach ($todos as $todo): ?>
                        <div class="view-read-card">
                            <div class="view-read-header">
                                <p class="view-read-organisatie"><?php
                                    foreach ($sections as $section) {
                                        if ($section['id'] == $todo['section']) {
                                            echo htmlspecialchars($section['name']);
                                        }
                                    }
                                    ?></p>
                                <p class="view-read-deadline">
                                    <span class="view-read-deadline-text"><?php echo $amountHandler->formatDate($todo['deadline']); ?></span>
                                    <?php if (strtotime($todo['deadline']) < time()): ?>
                                        <span class="deadline-warning" title="Deadline verstreken">❗</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="view-read-card-container">
                                <p class="view-read-title"><?php echo htmlspecialchars($todo['title']); ?></p>
                                <p class="view-read-description"><?php echo htmlspecialchars($todo['description']); ?></p>
                                <div class="view-read-under">
                                    <p class="view-read-status"><?php echo htmlspecialchars($todo['status']); ?></p>
                                    <a href="update.php?id=<?php echo $todo['id']; ?>" class="view-read-update-btn">
                                        ✏️ Aanpassen
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;

                    $totalUserTodos = $amountHandler->getTotalUserTodos($_SESSION['user_id']);
                    if (count($todos) < $totalUserTodos): ?>
                        <a href="<?php echo $base_url ?>/tasks/?show=<?php echo $amountHandler->getNewAmount($amount, $_SESSION['user_id']); ?>
                        &name=<?php echo $title; ?>
                        &organization=<?php echo $organization; ?>
                        &status=<?php echo $status; ?>
                        &deadline=<?php echo $deadline; ?>"
                           class="show-more-btn">
                            Show more
                            <svg class="arrow-icon" width="12" height="12" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once '../layout/footer.php'; ?>
</body>
</html>