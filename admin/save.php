<?php
require 'auth.php';

$dataFile = __DIR__ . '/../data/products.json';

$json = $_POST['json'] ?? '';

json_decode($json);
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Ошибка JSON');
}

file_put_contents($dataFile, $json);
header('Location: panel.php');
