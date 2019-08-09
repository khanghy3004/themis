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

if ( !$_SESSION['user_id'] )
{ 
	echo "Bạn chưa đăng nhập! <a href='login.php'>Nhấp vào đây để đăng nhập</a> hoặc <a href='register.php'>Nhấp vào đây để đăng ký</a>"; 
}
else
{ 
	//check xem co duoc edit hay ko?
	
	$sql_query = "SELECT * FROM caidat WHERE id='1'"; 
	$caidat1 = $conn->query($sql_query); 
	$caidat = $caidat1->fetch_assoc();
	
	$chophepedit = "{$caidat['editprofile']}";
	
	
	$user_id = intval($_SESSION['user_id']);
 
	$sql_query = "SELECT * FROM members WHERE id='{$user_id}'"; 
	$member1 = $conn->query($sql_query); 
	$member = $member1->fetch_assoc();
	
	if ($member['admin'] == "0"){
	if ($chophepedit == 0) 
		{
			echo "<font color='red'><b>Admin đã tắt chức năng thay đổi mật khẩu, vui lòng liên hệ admin để được trợ giúp!</b>";
			exit;
		}
	}
	
	//----Noi dung thong bao sau khi sua
	$thanhcong='Sửa thành công <a href="javascript:history.go(-1)">Quay lại</a>';
	$kothanh='Sửa không thành công';
	echo "<p><h3>Thay đổi mật khẩu: <b>{$member['username']}</b></h3></p>"; 
		
		
		
	if (isset($_GET['do'])&&$_GET['do']=="sua") {//fix  Undefined index
		$pass = md5( addslashes( $_POST['pass'] ) );
		
		if ($sua=$conn->query($sql))
			echo $thanhcong;
		else
			echo $kothanh;
			
		if (isset($_POST['pass'])&&$_POST['pass']!="") {//fix  Undefined index
			$sqlx="UPDATE `members` SET `password` = '".$pass."' WHERE `id` = '$user_id' LIMIT 1 ;";
			$suapass=$conn->query($sqlx);
			if ($suapass) 
				echo " (Đã đổi pass) ";
			else
				echo "(Chưa đổi pass) ";
		}
	}
	else
		echo"
		<form method='POST' action='suathongtin.php?do=sua&CBHT=edit'>
			<p> Nhập mật khẩu mới:
			<input class='form-control' type='password' name='pass' size='20'></p>
			<p> Nhập lại mật khẩu mới:
			<input class='form-control' type='password' name='pass' size='20'></p>
			<p'><input class='btn btn-info' type='submit' value='Chấp nhận'></p>
		</form>
		
                            
        </div></div>";
} 
?>
</div>