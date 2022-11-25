<html lang="ru">
<head>
    <title>Список файлов</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>
    <link rel="stylesheet" href="../css/<?php echo $_COOKIE['theme']; ?>.css" type="text/css">
</head>
<body>
<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
if (!is_dir($path)) {
    mkdir($path, 0777, true);
}
$uploaded_files = "";
$files = opendir($path);
while (($file = readdir($files)) !== false) {
    if ($file != '.' && $file != '..') {
        $filename = $path . $file;
        $parts = explode("_", $file);
        $size = filesize($filename);
        $added = date("F d Y H:i:s.", filectime($filename));
        $uploaded_files .= "<li><form action='../api/actions/download.php' method='post'><button type='submit' value='$filename' name='filename'>Скачать</button> $file Размер: $size байт; Добавлен: $added</li></form>\n";
    }
}
closedir($files);
if (strlen($uploaded_files) == 0) {
    $uploaded_files = "<li><em>Файлы не найдены</em></li>";
}
echo "<ul id='files'>";
echo $uploaded_files;
echo "</ul>";
?>
</body>
</html>


