<?php
require "../conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    die('Доступ запрещен: форма должна отправляться методом POST.');
}

function validate($data)
{
    return htmlspecialchars(trim($data));
}

$login = validate($_POST['login']);
$password = validate($_POST['password']);

if ($password == 'password' && $login == "admin") {
    $_SESSION['is_admin'] = true;
    echo json_encode(['success' => true, 'message' => "Админ"]);
    pg_close($conn);
    exit;
}

$check_user = "SELECT * from users where login=$1";
$res = pg_query_params($conn, $check_user, [$login]);

if (pg_num_rows($res) == 1) {
    $user = pg_fetch_assoc($res);
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => "Неверный пароль!"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => "Неверный логин!"]);
}


pg_close($conn);
