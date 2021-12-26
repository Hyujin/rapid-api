<?php

$call_date = $_POST['call_date'];
$talk_time = $_POST['talk_time'];
$cx_phone = $_POST['cx_phone'];
$answer_time = $_POST['answer_time'];
$call_id = $_POST['call_id'];
$acct_id = $_POST['acct_id'];



$db_host = "localhost";
$db_user = "root";
$db_pass = "Altria123!@#";
$db_name = "auto_api";

mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);


if (!$con) { die('Error: ' . mysql_error()); }


$db = "INSERT INTO api_logs ";



$con->close();

header("Location: index.php?status=sent");


?>