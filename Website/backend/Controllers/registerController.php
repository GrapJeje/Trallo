<?php

global $conn, $base_url;
session_start();

require_once '../conn.php';

$email = $_POST['email'];
$password = $_POST['password'];
$second_password = $_POST['second_password'];

function redirectWithMessage($url, $message)
{
    header("Location: $url?msg=$message");
    exit();
}

if (empty($email) || empty($password) || empty($second_password)) {
    redirectWithMessage($base_url . "/register", "Vul alle velden in");
}

if ($password !== $second_password) {
    redirectWithMessage($base_url . "/register", "Wachtwoorden komen niet overeen");
}

$query = "SELECT id FROM users WHERE email = :email";
$statement = $conn->prepare($query);
$statement->bindParam(':email', $email, PDO::PARAM_STR);
$statement->execute();

if ($statement->rowCount() > 0) {
    redirectWithMessage($base_url . "/register", "Email is al in gebruik");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$query = "INSERT INTO users (email, password) VALUES (:email, :password)";
$statement = $conn->prepare($query);
$statement->bindParam(':email', $email, PDO::PARAM_STR);
$statement->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
$statement->execute();

$userId = $conn->lastInsertId();
$_SESSION['user_id'] = $userId;
$_SESSION['user_email'] = $email;

$alert = "Succesvol geregistreerd!";
header("Location:" . $base_url . "/tasks?=alert=$alert");
exit();
