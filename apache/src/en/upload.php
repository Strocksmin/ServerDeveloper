<html lang="en">
<head>
    <title>Upload files</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>
    <link rel="stylesheet" href="../css/<?php echo $_COOKIE['theme']; ?>.css" type="text/css">
</head>
<body>
<form action="/upload.php" method="post" enctype="multipart/form-data" class="uploadForm">

    <input type="file" name="file[]" multiple>

    <input type="submit" value="Upload">

</form>
</body>
</html>
<?php
$input_name = 'file';
$allow = array('pdf');

// Директория куда будут загружаться файлы.
$path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

if (isset($_FILES[$input_name])) {
    // Проверим директорию для загрузки.
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    // Преобразуем массив $_FILES в удобный вид для перебора в foreach.
    $files = array();
    $diff = count($_FILES[$input_name]) - count($_FILES[$input_name], COUNT_RECURSIVE);
    if ($diff == 0) {
        $files = array($_FILES[$input_name]);
    } else {
        foreach ($_FILES[$input_name] as $k => $l) {
            foreach ($l as $i => $v) {
                $files[$i][$k] = $v;
            }
        }
    }

    foreach ($files as $file) {
        $error = $success = '';

        // Проверим на ошибки загрузки.
        if (!empty($file['error']) || empty($file['tmp_name'])) {
            switch (@$file['error']) {
                case 1:
                case 2:
                    $error = 'Filesize is above the filesize limit.';
                    break;
                case 3:
                    $error = 'File was partly uploaded.';
                    break;
                case 4:
                    $error = 'Failed to upload a file.';
                    break;
                case 6:
                    $error = 'Failed to upload a file - no temporary directory.';
                    break;
                case 7:
                    $error = 'Failed to write file to disk.';
                    break;
                case 8:
                    $error = 'PHP-extension has stopped the upload.';
                    break;
                case 9:
                    $error = 'Failed to upload a file - no directory.';
                    break;
                case 10:
                    $error = 'Filesize is above the limit.';
                    break;
                case 11:
                    $error = 'Illegal file type.';
                    break;
                case 12:
                    $error = 'File copy error.';
                    break;
                default:
                    $error = 'Failed to upload a file - unknown error.';
                    break;
            }
        } elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
            $error = 'Failed to upload a file.';
        } else {
            // Оставляем в имени файла только буквы, цифры и некоторые символы.
            $pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
            $name = mb_eregi_replace($pattern, '-', $file['name']);
            $name = mb_ereg_replace('[-]+', '-', $name);

            // Т.к. есть проблема с кириллицей в названиях файлов (файлы становятся недоступны).
            // Сделаем их транслит:
            $converter = array(
                'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
                'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k',
                'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
                'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
                'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
                'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

                'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
                'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K',
                'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
                'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
                'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch', 'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
                'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            );

            $name = strtr($name, $converter);
            $parts = pathinfo($name);

            if (empty($name) || empty($parts['extension'])) {
                $error = 'Illegal file name';
            } elseif (!empty($allow) && !in_array(strtolower($parts['extension']), $allow)) {
                $error = 'Illegal file type';
            } else {
                // Чтобы не затереть файл с таким же названием, добавим префикс.
                $i = 0;
                $prefix = '';
                while (is_file($path . $parts['filename'] . $prefix . '.' . $parts['extension'])) {
                    $prefix = '(' . ++$i . ')';
                }
                $name = $parts['filename'] . $prefix . '.' . $parts['extension'];

                // Перемещаем файл в директорию.
                if (move_uploaded_file($file['tmp_name'], $path . $name)) {
                    // Далее можно сохранить название файла в БД и т.п.
                    $success = 'File «' . $name . '» was uploaded.';
                } else {
                    $error = 'Failed to upload a file.';
                }
            }
        }

        // Выводим сообщение о результате загрузки.
        if (!empty($success)) {
            echo '<p>' . $success . '</p>';
        } else {
            echo '<p>' . $error . '</p>';
        }
    }
}