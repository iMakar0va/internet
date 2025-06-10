<?php
session_start();
require "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php"); // Редирект на страницу входа
    exit();
}

$user_id = $_SESSION['user_id'];
$get_apps = "SELECT * from applications where user_id=$1";
$res_apps = pg_query_params($conn, $get_apps, [$user_id]);
$applications = pg_fetch_all($res_apps) ?: [];

$get_user = "SELECT * from users where user_id=$1";
$res_user = pg_query_params($conn, $get_user, [$user_id]);
$user = pg_fetch_assoc($res_user);
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
            <h2>ТехПоддержка Онлайн</h2>
            <div class="block">
                <div class="text"><?= htmlspecialchars($user['last_name']) . " " . htmlspecialchars($user['first_name']) ?></div>
                <a href="logout.php">Выйти</a>
            </div>
        </header>
        <div class="title">
            <a href="#!" onclick="window.history.back(); return false;"><img src="icons8-arrow-50.png" alt="">Вернуться назад</a>
        </div>
        <form id="createForm">
            <h2>Создание заявки</h2>
            <label for="problem">Тип проблемы:</label>
            <select name="problem" id="problem">
                <option value="">--Выберите тип проблемы--</option>
                <option value="Нет интернета">Нет интернета</option>
                <option value="Медленная скорость">Медленная скорость</option>
                <option value="Проблемы с ТВ">Проблемы с ТВ</option>
                <option value="Другое">Другое</option>
            </select>
            <textarea name="otherProblem" id="otherProblem" cols="30" rows="10" style="display: none;"></textarea>
            <label for="date">Дата:</label>
            <input type="date" name="date" id="date">
            <label for="time">Время:</label>
            <input type="time" name="time" id="time">
            <label for="priority">Приоритет:</label>
            <select name="priority" id="priority">
                <option value="">--Выберите приоритет--</option>
                <option value="Низкий">Низкий</option>
                <option value="Средний">Средний</option>
                <option value="Высокий">Высокий</option>
            </select>
            <div id="errorMessage"></div>
            <button type="submit">Создать</button>
        </form>
    </div>

    <script src="scripts/create_app.js"></script>
</body>

</html>