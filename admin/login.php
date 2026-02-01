<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['login'] === 'admin' && $_POST['password'] === 'admin123') {
        $_SESSION['auth'] = true;
        header('Location: panel.php');
        exit;
    } else {
        $error = 'Неверный логин или пароль';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Admin Login</title></head>
<body>
<h2>Вход в админку</h2>
<form method="post">
  <input name="login" placeholder="Логин"><br><br>
  <input name="password" type="password" placeholder="Пароль"><br><br>
  <button type="submit">Войти</button>
</form>
<p style="color:red"><?= $error ?></p>
</body>
</html>
