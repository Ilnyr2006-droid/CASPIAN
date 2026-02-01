<?php
require 'auth.php';

$dataFile = __DIR__ . '/../data/products.json';
$json = file_exists($dataFile) ? file_get_contents($dataFile) : '{}';
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Admin Panel</title></head>
<body>
<h2>Редактирование products.json</h2>

<form method="post" action="save.php">
  <textarea name="json" style="width:100%;height:400px;"><?= htmlspecialchars($json) ?></textarea><br><br>
  <button type="submit">Сохранить</button>
</form>

<br>
<a href="logout.php">Выйти</a>
</body>
</html>
