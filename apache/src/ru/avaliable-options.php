<html lang="ru">
<head>
    <title>Возможнные действия</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>
    <link rel="stylesheet" href="../css/<?php echo $_COOKIE['theme']; ?>.css" type="text/css">
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
$login = $_COOKIE['login'];
if (!isset($login)) {
    echo "Вы не вошли в аккаунт";
    header("Location: https://localhost:8081/signin.html");
    exit();
} else {
    $database = new Database();
    $connection = $database->getConnection();
    $role = $connection->query(/** @lang MySQL */ "SELECT role from users where name='$login'")->fetch_row()[0];
    if ($role == 'admin') {
        echo "<a href='admin.php'>Список всех пользователй</a><br>";
    }
    echo "<a href='menu.php'>Меню</a><br>";
    echo "<a href='upload.php'>Загрузить файл</a><br>";
    echo "<a href='file-list.php'>Список файлов</a><br>";
    echo "<a href='http://localhost:8080/statistics.php'>Статистика</a><br>";
    $count = $_SESSION['count'] ?? 1;
    echo "<p>Число просмотров этой страницы в этой сессии: $count</p>";
    $_SESSION['count'] = ++$count;
}
?>
</body>
</html>

