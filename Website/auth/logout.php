<?php
require_once '../backend/config.php';
global $base_url;
session_start();
session_destroy();
$alert = "Succesvol uitgelogd!";
header("Location: $base_url?alert=$alert");
exit;