<?php

//start: fix  Undefined index
if(!isset($_GET["CBHT"])){
	$_GET["CBHT"]='';
}
//end: fix  Undefined index
include_once("dulieu/header.php");
?>

<div class="container">
<?php
if ((isset($_SESSION['user_id']))/* or ($_SESSION['user_id']==1)*/)////fix  Undefined index
{
	/// tat reg ac 
	$sql_query = "SELECT * FROM caidat WHERE id='1'"; 
	$caidat1 = $conn->query($sql_query); 
	$caidat = $caidat1->fetch_assoc();
	
	$chophepdangky = "{$caidat['registeron']}";
	if (!isset($_SESSION['user_id'])) {
	if ($chophepdangky == 0) 
		{
			echo "<font color='red'><b>Admin đã tắt chức năng đăng ký tài khoản, vui lòng liên hệ admin để được hỗ trợ!</b>";
			exit;
		}
	}
	/// tat reg ac

if (isset($_GET['act']) && $_GET['act'] == "do" )//fix  Undefined index
{
	// Dùng hàm addslashes() để tránh SQL injection, dùng hàm md5() để mã hóa password
	$username = addslashes( $_POST['username'] );
	$password = md5( addslashes( $_POST['password'] ) );
	$verify_password = md5( addslashes( $_POST['verify_password'] ) );
	$ten = addslashes( $_POST['name'] );

	// Kiểm tra 7 thông tin, nếu có bất kỳ thông tin chưa điền thì sẽ báo lỗi
	if ( ! $username || ! $_POST['password'] || ! $_POST['verify_password'] || ! $ten)
	{
		print "<font color='red'><b>ERROR!!!<br>Xin vui lòng nhập đầy đủ các thông tin.</b></font> <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a>";
		exit;
	}
	//kiem tra user hop le
	if (!preg_match('/^[_a-z-0-9-A-Z]+$/', $username, $matches))
	{
		print "<font color='red'><b>ERROR!!!<br>Username không hợp lệ, username chỉ cho phép [a->z],[A->Z], [0->9].</b></font> <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a>";
		exit;
	}
	
	// Kiểm tra username nay co nguoi dung chua
	if ( $conn->query("SELECT username FROM members WHERE username='$username'")->num_rows>0)
	{
		print "<font color='red'><b>ERROR!!!<br>Username này đã có người dùng, Bạn vui lòng chọn username khác.</b></font> <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a>";
		exit;
	}
	// Kiểm tra mật khẩu, bắt buộc mật khẩu nhập lúc đầu và mật khẩu lúc sau phải trùng nhau
	if ( $password != $verify_password )
	{
		print "Mật khẩu không giống nhau, bạn hãy nhập lại mật khẩu. <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a>";
		exit;
	}
	// Tiến hành tạo tài khoản
	 $a=$conn->query("INSERT INTO members (username, password,Name) VALUES ('{$username}', '{$password}',  '{$ten}')");
	// Thông báo hoàn tất việc tạo tài khoản
	if ($a)
		print "<font color='Green'><b>Done!!!<br>Tài khoản {$username} đã được tạo.</b></font> <a href='login.php'>Nhấp vào đây để đăng nhập</a>";
	else
		print "Có lỗi trong quá trình đăng kí, Vui lòng liên hệ BQT";
}
else
{
// Form đăng ký
print <<<EOF
<h3>Đăng ký thành viên</h3>
<form action="register.php?act=do" method="post">
	<table border="0" width="400" cellspacing="1" style="border-collapse: collapse" bordercolor="#C0C0C0">
		<tr>
			<td>Tên truy nhập <font color='red'>(*)</font>:</td>
			<td><input  class="form-control" type="text" name="username" value=""></td>
		</tr>
		<tr>
			<td>Tên của bạn <font color='red'>(*)</font>:</td>
			<td><input class="form-control"  type="text" name="name" value=""></td>
		</tr>
		<tr>
			<td>Mật khẩu <font color='red'>(*)</font>:</td>
			<td><input  class="form-control" type="password" name="password" value=""></td>
		</tr>
		<tr>
			<td>Xác nhận mật khẩu <font color='red'>(*)</font>:</td>
			<td><input class="form-control"  type="password" name="verify_password" value=""></td>
		</tr>
		<tr>
			<td><font color='red'>(*) là phần bắt buộc phải ghi</font></td>
			<td><br><input class="btn btn-sm btn-primary"  type="submit" name="submit" value="Đăng ký tài khoản"></td>
		</tr>
		
	</table>
</form></div></div>
EOF;
}
}
else
{
	echo "Bạn đã đăng nhập vào tài khoản với tên {$member['username']}";
}
?>
</div>