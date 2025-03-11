<?php
    session_start();

    // Bewaar form data in variabelen
    $user_id = $_SESSION["user_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $section = $_POST["section"];
    $status = $_POST["status"];

    // Voeg taak toe
    require_once "../conn.php";

    $query = "INSERT INTO planning_board (user_id, title, description, section, status)
    VALUES(:user_id, :title, :description, :section, :status)";

    $statement = $conn->prepare($query);

    $statement->execute([
        ":user_id" => $user_id,
        ":title" => $title,
        ":description" => $description,
        ":section" => $section,
        ":status" => $status,
    ]);

    header("Location: $base_url/tasks/");
?>