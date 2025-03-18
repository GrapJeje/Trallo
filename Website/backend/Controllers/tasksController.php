<?php
global $conn, $base_url;
session_start();

require_once "../conn.php";

$action = $_POST["action"];
$user_id = $_SESSION["user_id"];

if ($action === "create")
{
    // Bewaar form data in variabelen
    $title = $_POST["title"];
    $description = $_POST["description"];
    $section = $_POST["section"];
    $status = $_POST["status"];
    $deadline = $_POST["deadline"];

    // Voeg taak toe
    $query = "INSERT INTO planning_board (user_id, title, description, section, status, deadline)
    VALUES(:user_id, :title, :description, :section, :status, :deadline)";

    $statement = $conn->prepare($query);

    $statement->execute([
        ":user_id" => $user_id,
        ":title" => $title,
        ":description" => $description,
        ":section" => $section,
        ":status" => $status,
        ":deadline" => $deadline,
    ]);

    header("Location: $base_url/tasks");
    exit();
}
else if ($action == "update")
{
    // Bewaar form data in variabelen
    $title = $_POST["title"];
    $description = $_POST["description"];
    $section = $_POST["section"];
    $status = $_POST["status"];
    $id = $_POST["id"];
    $deadline = $_POST["deadline"];

    $query = "UPDATE planning_board SET title = :title, description = :description, section = :section, status = :status, deadline = :deadline 
                      WHERE id = :id AND user_id = :user_id";

    $statement = $conn->prepare($query);

    $statement->execute([
        ":user_id" => $user_id,
        ":title" => $title,
        ":description" => $description,
        ":section" => $section,
        ":status" => $status,
        ":id" => $id,
        ":deadline" => $deadline,
    ]);

    header("Location: $base_url/tasks");
    exit();
}