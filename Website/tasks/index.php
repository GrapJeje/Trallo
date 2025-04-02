<!doctype html>
<html lang="nl">

<head>
    <?php require_once "../layout/head.php"; ?>
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

$title = isset($_GET['name']) ? $_GET['name'] : '';
$organization = isset($_GET['organization']) ? $_GET['organization'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$deadline = isset($_GET['deadline']) ? $_GET['deadline'] : 'desc';

$query = "SELECT * FROM planning_board WHERE 1=1";

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

if (!empty($title)) $statement->bindValue(':title', '%' . $title . '%');
if (!empty($organization)) $statement->bindValue(':organization', $organization);
if (!empty($status)) $statement->bindValue(':status', $status);
$statement->bindValue(':amount', $amount, PDO::PARAM_INT);

$statement->execute();
$todos = $statement->fetchAll(PDO::FETCH_ASSOC);

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
                               value="<?php echo $title; ?>">
                        <select name="organization" class="filter-select">
                            <option value="">Organisatie</option>
                            <option value="section1" <?php echo $organization == 'section1' ? 'selected' : ''; ?>>
                                Section1
                            </option>
                            <option value="section2" <?php echo $organization == 'section2' ? 'selected' : ''; ?>>
                                Section2
                            </option>
                            <option value="section3" <?php echo $organization == 'section3' ? 'selected' : ''; ?>>
                                Section3
                            </option>
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

                <?php
                // Filter todos by user_id
                $filteredTodos = array_filter($todos, function ($todo) {
                    return $todo['user_id'] == $_SESSION['user_id'];
                });

                if (empty($filteredTodos)): ?>
                    <p>Geen taken gevonden</p>
                <?php else:
                    foreach ($filteredTodos as $todo): ?>
                        <div class="view-read-card">
                            <div class="view-read-header">
                                <p class="view-read-organisatie"><?php echo $todo['section']; ?></p>
                                <p class="view-read-deadline">
                                    <span class="view-read-deadline-text"><?php echo $amountHandler->formatDate($todo['deadline']); ?></span>
                                    <?php if (strtotime($todo['deadline']) < time()): ?>
                                        <span class="deadline-warning" title="Deadline verstreken">❗</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="view-read-card-container">
                                <p class="view-read-title"><?php echo $todo['title']; ?></p>
                                <p class="view-read-description"><?php echo $todo['description']; ?></p>
                                <div class="view-read-under">
                                    <p class="view-read-status"><?php echo $todo['status']; ?></p>
                                    <a href="update.php?id=<?php echo $todo['id']; ?>" class="view-read-update-btn">
                                        ✏️ Aanpassen
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <a href="<?php echo $base_url ?>/tasks/?show=<?php echo $amountHandler->getNewAmount($amount); ?>&name=<?php echo $title; ?>&organization=<?php echo $organization; ?>&status=<?php echo $status; ?>&deadline=<?php echo $deadline; ?>"
                       class="show-more-btn">
                        Show more
                        <svg class="arrow-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php endif; ?>


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

        $filteredTodos = array_filter($todos, function ($todo) {
            return $todo['user_id'] == $_SESSION['user_id'];
        });

        $maxAmount = count($filteredTodos);

        $amount += 5;
        if ($amount > $maxAmount) {
            $amount = $maxAmount;
        }

        return $amount;
    }

    function formatDate($inputDate)
    {
        $months = [
            'Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni',
            'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'
        ];

        list($year, $month, $day) = explode('-', $inputDate);
        return (int)$day . ' ' . $months[(int)$month - 1] . ' ' . $year;
    }
}
