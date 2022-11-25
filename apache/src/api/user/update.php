<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "api/config/database.php";
include_once "api/objects/user.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->id = $data->id;

$user->name = $data->name;
$user->password = $data->password;
$user->role = $data->role;

if ($user->update()) {
    http_response_code(200);

    echo json_encode(array("message" => "Пользователь был обновлён."), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Невозможно обновить пользователя."), JSON_UNESCAPED_UNICODE);
}