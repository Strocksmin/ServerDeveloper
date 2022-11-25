<?php
session_start();
$method = $_SERVER['REQUEST_METHOD'];

$url = (isset($_GET['q'])) ? $_GET['q'] : '';
$url = rtrim($url, '/');
$urls = explode('/', $url);
if ($urls[0] == "api") {
    switch ($urls[1]):
        case "product":
        {
            switch ($method):
                case "GET":
                {
                    if (isset($urls[2]) and ctype_digit($urls[2])) {
                        $id = intval($urls[2]);
                        include_once "api/product/read_one.php";
                    } else include_once "api/product/read.php";
                    break;
                }
                case "POST":
                {
                    include_once "api/product/create.php";
                    break;
                }
                case "PUT":
                {
                    include_once "api/product/update.php";
                    break;
                }
                case "DELETE":
                {
                    if (isset($urls[2]) and ctype_digit($urls[2])) {
                        $id = intval($urls[2]);
                        include_once "api/product/delete.php";
                    }
                    break;
                }
            endswitch;
            break;
        }
        case "user":
        {
            switch ($method):
                case "GET":
                {
                    if (isset($urls[2]) and ctype_digit($urls[2])) {
                        $id = intval($urls[2]);
                        include_once "api/user/read_one.php";
                    } else {
                        include_once "api/user/read.php";
                    }
                    break;
                }
                case "POST":
                {
                    include_once "api/user/create.php";
                    break;
                }
                case "PUT":
                {
                    include_once "api/user/update.php";
                    break;
                }
                case "DELETE":
                {
                    if (isset($urls[2]) and ctype_digit($urls[2])) {
                        $id = intval($urls[2]);
                        include_once "api/user/delete.php";
                    }
                    break;
                }
            endswitch;
            break;
        }
    endswitch;
} else {
    $lang = @$_COOKIE["lang"];
    if ($lang == "ru") {
        include_once "ru/" . $urls[0];
    } elseif ($lang == "en") include_once "en/" . $urls[0];
}
