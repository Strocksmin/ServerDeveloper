<?php
include_once '../config/database.php';
header('Access-Control-Allow-Origin: *');
$name = $_POST["name"];
$password = $_POST["password"];
$theme = $_POST["theme"];
$lang = $_POST["lang"];
if (!isset($name) and !isset($password)) {
    header("Location: http://localhost:8081/signin.html");
    exit();
}
$database = new Database();
$connection = $database->getConnection();
if (mysqli_connect_errno()) {
    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
}
$result = $connection->query(/** @lang MySQL */ "SELECT role from users where name='$name' and password='$password'");
if ($result->num_rows == 1) {
    setcookie('role', $result->fetch_row()[0], time()+60*60*24*1, '/');
    setcookie('login', $name, time()+60*60*24, '/');
    setcookie('theme', $theme, time()+60*60*24, '/');
    setcookie('lang', $lang, time()+60*60*24, '/');
    header("Location: http://localhost:8080/avaliable-options.php");
} else {
    echo "Неправильные данные <br>";
    echo "<a href='http://localhost:8081/signin.html'>Войти снова</.a>";
}
$connection->close();
exit();
