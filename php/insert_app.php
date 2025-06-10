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

$problem = validate($_POST['problem']);
$other_problem = validate($_POST['otherProblem']);
$priority = validate($_POST['priority']);
$date = validate($_POST['date']);
$time = validate($_POST['time']);

$final_problem = $other_problem == "" ? $problem : $other_problem;
$user_id = $_SESSION['user_id'];
$insert_app = "INSERT into applications (user_id,problem,date,time,priority) values ($1,$2,$3,$4,$5)";
$res = pg_query_params($conn, $insert_app, [$user_id, $final_problem, $date, $time, $priority]);

if ($res) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => "Ошибка создания заявки"]);
}


pg_close($conn);
