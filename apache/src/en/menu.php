<html lang="en">
<head>
    <title>Menu</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>
    <link rel="stylesheet" href="../css/<?php echo $_COOKIE['theme']; ?>.css" type="text/css">
</head>
<body>
<h1>Menu</h1>
<table>
    <tr>
        <th>Name</th>
        <th>Volume</th>
        <th>Price</th>
    </tr>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
    $database = new Database();
    $connection = $database->getConnection();
    $result = $connection->query(/** @lang MySQL */ "SELECT * FROM products");
    foreach ($result as $row) {
        echo "<tr><td>{$row['name']}</td><td>{$row['volume']}</td><td>{$row['price']}</td></tr>";
    }
    $connection->close();
    ?>
</table>
</body>
</html>
