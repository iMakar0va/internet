<?php
require "../conn.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    die('Доступ запрещен: форма должна отправляться методом POST.');
}
function validate($data)
{
    return htmlspecialchars(trim($data));
}

$last_name = validate($_POST['last_name']);
$first_name = validate($_POST['first_name']);
$father_name = validate($_POST['father_name']);
$login = validate($_POST['login']);
$password = validate($_POST['password']);
$phone = validate($_POST['phone']);
$email = validate($_POST['email']);

$hash_password = password_hash($password, PASSWORD_DEFAULT);

$check_user = "SELECT * from users where login=$1";
$res = pg_query_params($conn, $check_user, [$login]);

if (pg_num_rows($res) > 0 || $login == "admin") {
    echo json_encode(['success' => false, 'message' => "Неуникальный логин!"]);
    pg_close($conn);
    exit;
}

$insert_user = "INSERT INTO users (last_name,first_name,father_name,login,password,email,phone) values ($1,$2,$3,$4,$5,$6,$7)";
$res = pg_query_params($conn, $insert_user, [$last_name, $first_name, $father_name, $login, $hash_password, $email, $phone]);

if ($res) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => "Ошибка при регистрации!"]);
}

pg_close($conn);
