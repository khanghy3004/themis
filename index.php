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
	break;
	}	
	case "rank":
	{
	include_once("dulieu/header.php");
	include_once("rank.php");
	break;
	}
	case "thoat":
	{
	include_once("dulieu/header.php");
	include_once("thoat.php");
	break;
	}
	case "submit":
	{
	include_once("dulieu/header.php");
	include_once("submit.php");
	break;
	}
}

?>
