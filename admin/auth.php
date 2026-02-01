<?php
session_start();

$ADMIN_LOGIN = 'admin';
$ADMIN_PASSWORD = 'admin123'; // поменяешь позже

if (!isset($_SESSION['auth'])) {
    header('Location: login.php');
    exit;
}
