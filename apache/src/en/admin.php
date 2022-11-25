<html lang="en">
<head>
    <title>User list</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>
    <link rel="stylesheet" href="../css/<?php echo $_COOKIE['theme']; ?>.css" type="text/css">
</head>
<body>
<h1>Table of users</h1>
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Password</th>
        <th>Role</th>
    </tr>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
    $database = new Database();
    $connection = $database->getConnection();
    $result = $connection->query(/** @lang MySQL */ "SELECT * FROM users");
    foreach ($result as $row) {
        echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['password']}</td><td>{$row['role']}</td></tr>";
    }
    $connection->close();
    ?>
</table>
</body>
</html>
