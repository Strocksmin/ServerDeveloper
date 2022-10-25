<?php
function connectToDB(): mysqli
{
    $mysqli = new mysqli("mysql", "user", "password", "appDB", "3306");
    mysqli_set_charset($mysqli, 'utf8');
    return $mysqli;
}