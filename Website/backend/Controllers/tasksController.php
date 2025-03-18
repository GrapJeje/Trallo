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

    // Voeg taak toe
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

    $query = "UPDATE planning_board SET title = :title, description = :description, section = :section, status = :status 
                      WHERE id = :id AND user_id = :user_id";

    $statement = $conn->prepare($query);

    $statement->execute([
        ":user_id" => $user_id,
        ":title" => $title,
        ":description" => $description,
        ":section" => $section,
        ":status" => $status,
        ":id" => $id,
    ]);

    header("Location: $base_url/tasks");
    exit();
}