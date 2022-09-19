<?php
$num = isset($_GET['num'] ) ? $_GET['num']  : 1;
$width = $num << 16;
$height = $num << 12;
$radius = $num << 4;
$radius2 = $num << 2;
$center = $num << 4;
if ($num % 5 == 0) {
    $color = "black";
} elseif ($num % 5 == 1) {
    $color = "green";
} elseif ($num % 5 == 2) {
    $color = "blue";
} elseif ($num % 5 == 3) {
    $color = "yellow";
} elseif ($num % 5 == 4) {
    $color = "purple";
} else {
    $color = "violet";
}
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Рисовашка</title>
</head>
<body>
<div class="svg">
    <svg width="800" height="800">
        <?php
        if ($num % 2 == 0) {
            echo "<circle cx='$center' cy='$center' r='$radius' fill='$color'/>";
        } elseif ($num % 3 == 0) {
            echo "<rect width='$width' height='$height' fill='$color'/>";
        }
        else {
            echo "<ellipse rx='$radius2' ry='$radius' cx='$center' cy='$center' fill='$color' />";
        }
        ?>
    </svg>
</div>
</body>
</html>