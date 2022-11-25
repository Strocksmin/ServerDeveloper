<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "api/config/database.php";
include_once "api/objects/product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$result = $product->read();

if ($result) {
    http_response_code(200);
    echo json_encode($result);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}