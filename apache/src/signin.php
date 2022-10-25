<?php
include_once 'mySQLConnection.php';
header('Access-Control-Allow-Origin: *');
$name = $_POST["name"];
$password = $_POST["password"];
if (!isset($name) and !isset($password)) {
    header("Location: http://localhost:8081/signin.html");
    exit();
}
$mysqli = connectToDB();
if (mysqli_connect_errno()) {
    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
}
$result = $mysqli->query(/** @lang MySQL */ "SELECT role from users where name='$name' and password='$password'");
if ($result->num_rows == 1) {
    $role = $result->fetch_row()[0];
    setcookie('auth', $role);
    header("Location: http://localhost:8080/avaliableOptions.php");
} else {
    echo "Неправильные данные <br>";
    echo "<a href='http://localhost:8081/signin.html'>Войти снова</.a>";
}
$mysqli->close();
exit();
