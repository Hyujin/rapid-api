<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "Altria123!@#";
$db_name = "auto_api";

mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);


if (!$con) { die('Error: ' . mysql_error()); }


$db = "DELETE * FROM clear_temp";



$con->close();

header("Location: index.php?status=sent");


/*header("Location: index.php?status=failed");*/


?>