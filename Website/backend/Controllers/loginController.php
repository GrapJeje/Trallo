<?php

global $conn, $base_url;
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email) || empty($password))
{
    $msg = "Vul alle velden in";
    header("Location: $base_url/login?msg=$msg");
    exit();
}

require_once '../conn.php';
$query = "SELECT * FROM users WHERE email = :email";
$statement = $conn->prepare($query);
$statement->execute([
    ":email" => $email
]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password']))
{
    $msg = "Gebruikersnaam of wachtwoord is onjuist";
    header("Location: $base_url/login?msg=$msg");
    exit();
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_email'] = $user['email'];

$alert = "Succesvol ingelogd!";
header("Location: $base_url/tasks?alert=$alert");
