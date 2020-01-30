<?php
//start: fix  Undefined index
if(!isset($_GET["CBHT"])){
	$_GET["CBHT"]='';
}
//end: fix  Undefined index
switch($_GET["CBHT"])
{
	default:
	{
	include_once("dulieu/header.php");
	include_once("dulieu/home.php");
	include_once("dulieu/footer.php");
	break;
	}	
	case "rank":
	{
	include_once("dulieu/header.php");
	include_once("rank.php");
	include_once("dulieu/footer.php");
	break;
	}
	case "thoat":
	{
	include_once("dulieu/header.php");
	include_once("thoat.php");
	include_once("dulieu/footer.php");
	break;
	}
	case "submit":
	{
	include_once("dulieu/header.php");
	include_once("submit.php");
	include_once("dulieu/footer.php");
	break;
	}
	case "edit":
	{
	include_once("dulieu/header.php");
	include_once("suathongtin.php");
	include_once("dulieu/footer.php");
	break;
	}
	case "time":
	{
	include_once("dulieu/header.php");
	include_once("time.php");
	include_once("dulieu/footer.php");
	break;
	}
	case "login":
	{
	include_once("dulieu/header.php");
	include_once("login.php");
	include_once("dulieu/footer.php");
	break;
	}
	case "register":
	{
	include_once("dulieu/header.php");
	include_once("register.php");
	include_once("dulieu/footer.php");
	break;
	}
}

?>
