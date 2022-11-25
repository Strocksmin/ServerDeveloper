<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "api/config/database.php";
include_once "api/objects/user.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->id = $id ?? die();

if ($user->delete()) {
    http_response_code(200);

    echo json_encode(array("message" => "Пользователь был удалён."), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Не удалось удалить пользователя."));
}