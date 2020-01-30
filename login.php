<?php
//start: fix  Undefined index
if(!isset($_GET["CBHT"])){
	$_GET["CBHT"]='';
}
//end: fix  Undefined index

include_once("dulieu/header.php");

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
// Check connection
if ($conn->connect_error) { die("không thể kết nối: " . $conn->connect_error); }



if (isset($_GET['act']) && $_GET['act'] == "do" )
{
	// Dùng hàm addslashes() để tránh SQL injection, dùng hàm md5() để mã hóa password
	$username = addslashes( $_POST['username'] );
	$password = md5( addslashes( $_POST['password'] ) );
	// Lấy thông tin của username đã nhập trong table members
	
	$sql_query = "SELECT id, username, admin, password FROM members WHERE username='{$username}'";
	
	// Nếu username này không tồn tại thì....
	$member1 = $conn->query($sql_query); 
	
	$member = $member1->fetch_assoc();
	
	
	if ( $member1->num_rows <= 0 )
	{
		print "<div class = container>"."Tên đăng nhập không tồn tại. <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a></div>"; 
		exit;
	}
	// Nếu username này tồn tại thì tiếp tục kiểm tra mật khẩu
	if ( $password != $member['password'] )
	{
		print "<div class = container>"."Nhập sai mật khẩu. <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a></div>"; 
		exit;
	}
	// Khởi động phiên làm việc (session)
	$_SESSION['user_id'] = $member['id'];
	$_SESSION['user_admin'] = $member['admin'];
	// Thông báo đăng nhập thành công

	print "<meta http-equiv='refresh' content='0; index.php'>";
}
else
{
// Form đăng nhập
	if (!isset($_SESSION['user_id'] ))//fix  Undefined index
{
print <<<EOF
<div class="container">
  <form action="login.php?act=do&CBHT=login" method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" placeholder="Username" name="username">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input id="password-field" type="password" class="form-control" placeholder="Password" name="password">
    </div>
    <div class="form-group">
   <input type="checkbox" onclick="showpassword()"> Show password</div>
    <script>
	function showpassword() {
	  var x = document.getElementById("password-field");
	  if (x.type === "password") {
	    x.type = "text";
	  } else {
	    x.type = "password";
	  }
	}
	</script>
    </script>
    <input type="submit" class="btn btn-info" name="submit" value="Log in">
  </form>
</div>
EOF;
}
}
?> 

