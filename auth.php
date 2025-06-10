<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: lk.php"); // Редирект на страницу входа
    exit();
}
if (isset($_SESSION['is_admin'])) {
    header("Location: admin.php"); // Редирект на страницу входа
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/main.css">
    <title>Авторизация</title>
</head>

<body>
    <div class="container">
        <header>
            <h1>ТехПоддержка Онлайн</h1>
        </header>
        <form id="authForm">
            <h2>Авторизация</h2>
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login" required>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            <div id="errorMessage"></div>
            <button type="submit">Войти</button>
            <div class="link">
                Нет аккаунта? <a href="reg.php">Создать</a>
            </div>
        </form>
    </div>

    <script src="scripts/auth.js"></script>
</body>

</html>