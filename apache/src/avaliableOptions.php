<?php
$role = $_COOKIE['auth'];
if (!isset($role)) {
    echo "Вы не вошли в аккаунт";
    header("Location: https://localhost:8081/signin.html");
    exit();
} else {
    if ($role == 'admin') {
        echo "<a href='admin.php'>Список всех пользователй</.a><br>";
    }
    echo "<a href='menu.php'>Меню</.a>";
}
?>
