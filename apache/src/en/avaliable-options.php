<html lang="en">
<head>
    <title>Avaliable options</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>
    <link rel="stylesheet" href="../css/<?php echo $_COOKIE['theme']; ?>.css" type="text/css">
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
$login = $_COOKIE['login'];
if (!isset($login)) {
    echo "You are not logged in";
    header("Location: https://localhost:8081/signin.html");
    exit();
} else {
    $database = new Database();
    $connection = $database->getConnection();
    $role = $connection->query(/** @lang MySQL */ "SELECT role from users where name='$login'")->fetch_row()[0];
    if ($role == 'admin') {
        echo "<a href='admin.php'>List of all users</a><br>";
    }
    echo "<a href='menu.php'>Menu</a><br>";
    echo "<a href='upload.php'>Upload file</a><br>";
    echo "<a href='file-list.php'>List of files</a><br>";
    echo "<a href='http://localhost:8080/statistics.php'>Statistics</a><br>";
    $count = $_SESSION['count'] ?? 1;
    echo "<p>Views: $count</p>";
    $_SESSION['count'] = ++$count;
}
?>
</body>
</html>

