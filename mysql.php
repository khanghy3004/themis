<?php

$db_host = "localhost"; // Giữ mặc định là localhost
$db_name	= 'themis';// Can thay doi
$db_username	= 'root'; //Can thay doi
$db_password	= '';//Can thay doi
//@mysql_connect("{$db_host}", "{$db_username}", "{$db_password}") or die("Không thể kết nối database");
//@mysql_select_db("{$db_name}") or die("Không thể chọn database");
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
mysqli_query($conn,"SET NAMES 'UTF8'");

// Check connection
if ($conn->connect_error) { die("không thể kết nối: " . $conn->connect_error); }

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

?>