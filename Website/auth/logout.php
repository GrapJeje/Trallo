<?php
require_once '../backend/config.php';
global $base_url;
session_start();
session_destroy();
header("Location: $base_url");
exit;