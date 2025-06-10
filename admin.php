<?php
session_start();
require "conn.php";

if (!isset($_SESSION['is_admin'])) {
    header("Location: auth.php"); // Редирект на страницу входа
    exit();
}

$get_apps = "SELECT * from applications order by date desc";
$res_apps = pg_query_params($conn, $get_apps, []);
$applications = pg_fetch_all($res_apps) ?: [];

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
    <header>
        <h2>ТехПоддержка Онлайн</h2>
        <div class="block">
            <div class="text">Администратор</div>
            <a href="logout.php">Выйти</a>
        </div>
    </header>
    <div class="title">
        <h3>Список всех заявок</h3>
    </div>
    <?php if (empty($applications)): ?>
        <p>Нет заявок</p>
    <? else: ?>
        <div class="cards">
            <? foreach ($applications as $app): ?>
                <div class="card" data-id="<?= htmlspecialchars($app['application_id']) ?>">
                    <div class="card_id"># <?= htmlspecialchars($app['application_id']) ?></div>
                    <div class="card_priority"><b>Приоритет:</b> <?= htmlspecialchars($app['priority']) ?></div>
                    <div class="card_problem"><b>Тип проблема:</b> <?= htmlspecialchars($app['problem']) ?></div>
                    <div class="card_date"><b>Дата:</b> <?= htmlspecialchars($app['date']) ?></div>
                    <div class="card_time"><b>Время:</b> <?= htmlspecialchars($app['time']) ?></div>
                    <div class="card_time"><b>Статус:</b></div>
                    <div class="status_group">
                        <label>
                            <input type="radio" name="status_<?= htmlspecialchars($app['application_id']) ?>" value="В обработке" <?= $app['status'] == 'В обработке' ? 'checked' : '' ?>>В обработке
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="status_<?= htmlspecialchars($app['application_id']) ?>" value="Решено" <?= $app['status'] == 'Решено' ? 'checked' : '' ?>>Решено
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="status_<?= htmlspecialchars($app['application_id']) ?>" value="Отклонено" <?= $app['status'] == 'Отклонено' ? 'checked' : '' ?>>Отклонено
                        </label>
                    </div>
                    <button id="btnUpdate">Сохранить статус</button>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <script src="scripts/update_app.js"></script>
</body>

</html>