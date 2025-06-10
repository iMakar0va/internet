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
    <title>Личный кабинет</title>
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
            <h3>Список всех заявок</h3>
            <a href="create_app.php"><img src="icons8-plus.svg" alt="">Создать заявку</a>
        </div>
        <?php if (empty($applications)): ?>
            <p>Нет заявок</p>
        <? else: ?>
            <div class="cards">
                <? foreach ($applications as $app): ?>
                    <div class="card">
                        <div class="card_id">#<?= htmlspecialchars($app['application_id']) ?></div>
                        <div class="card_priority"><b>Приоритет:</b> <?= htmlspecialchars($app['priority']) ?></div>
                        <div class="card_problem"><b>Тип проблема:</b> <?= htmlspecialchars($app['problem']) ?></div>
                        <div class="card_date"><b>Дата:</b> <?= htmlspecialchars($app['date']) ?></div>
                        <div class="card_time"><b>Время:</b> <?= htmlspecialchars($app['time']) ?></div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>

</body>

</html>