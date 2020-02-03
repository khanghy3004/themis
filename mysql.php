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
$sql        = "SELECT DATE_FORMAT(timebegin, '%d-%m-%Y %H:%i:%s') as timebegin, DATE_FORMAT(timeend, '%d-%m-%Y %H:%i:%s') as timeend, name, maxpoint FROM thoigian";
$result     = mysqli_query($conn, $sql);
while ($res = mysqli_fetch_array($result)) {
    $begin = $res['timebegin'];
    $date = $res['timeend'];
    $cname = $res['name'];
    define("MAX_POINT", floatval($res['maxpoint']), true);
    $progress = (strtotime(date('H:i:s')) - strtotime($begin))/(strtotime($date) - strtotime($begin)) * 100;
}
?>