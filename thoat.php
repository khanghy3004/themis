<?php
//session_start();
//header('Content-Type: text/html; charset=UTF-8');
if (session_destroy())
	{
	 echo "Đăng xuất thành công!";
	 echo"<meta http-equiv='refresh' content='0; index.php'>";
	}
else
	echo "Không thể thoát dc, có lỗi trong việc hủy session";

echo '<br><a href="index.php">Bấm vào đây để quay lại trang chủ<br></a>';
?>