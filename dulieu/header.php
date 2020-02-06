<?php 
session_start();
header('Content-Type: text/html; charset=UTF-8');
require_once("mysql.php"); 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title>FFuture 2020</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js"></script>
    <script src="jquery/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#myModal").modal('show');
        });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <a class="navbar-brand">FFUTRE2020</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li <?php if (($_GET["CBHT"])==""){echo 'class="active"';} ?>>
                <a class="nav-link" href="./">HOME</a>
            </li>
            <li <?php if (($_GET["CBHT"])=="rank"){echo 'class="active"';} ?>>
                <a class="nav-link" href="./?CBHT=rank">RANK</a>
            </li>
            <li <?php if (($_GET["CBHT"])=="help"){echo 'class="active"';} ?>>
                <a class="nav-link" href="./?CBHT=help">HELP</a>
            </li>
            <li>
                <a class="nav-link" href="./corona.php">CORONA</a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
                 <?php 
                if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'] )//fix  Undefined index
                {
                    echo "<li "; if (($_GET["CBHT"])=="login"){echo 'class="active"';}
                    echo"><a class='nav-link' href='./?CBHT=login'><div class='fa fa-sign-in'> LOG IN</div></a></li>   <li "; 
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                
                <?php
                    if (isset($_SESSION['user_id']) || $_SESSION['user_id'] ) 
                    {
                        $user_id = intval($_SESSION['user_id']); 
                        $sql_query = "SELECT * FROM members WHERE id='{$user_id}'"; 
                        $member1 = $conn->query($sql_query); 
                        $member = $member1->fetch_assoc();
                        echo "<li "; if (($_GET["CBHT"])=="submit"){echo 'class="active"';} echo">
                        <a class='btn btn-success' href='./?CBHT=submit'><div class='fa fa-upload'> SUBMIT</div></a></li>";   
                    } 

                    $user_id = intval($_SESSION['user_id']);
                    $sql_query = "SELECT * FROM members WHERE id='{$user_id}'"; 
                    $member1 = $conn->query($sql_query); 
                    $member = $member1->fetch_assoc();          
                    if($member['Name'] != '') {
                        echo "
                        <div class='dropdown'>
                        <a class='nav-link' data-toggle='dropdown' href=>{$member['Name']}</a>
                        <div class='dropdown-menu dropdown-menu-right'>
                        <a class='dropdown-item' href='./?CBHT=edit'><div class='fa fa-refresh'> Change password</div></a>
                        "?> <?php if ($_SESSION['user_admin'] == 1) 
                        {
                            echo "<a class='dropdown-item' href='./?CBHT=time'><div class='fa fa-edit'> Edit contest</div></a>
                            <a class='dropdown-item' href='./?CBHT=register'><div class='fa fa-user'> Add User</div></a>";           
                        }?>
                        <?php echo
                        "
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='./?CBHT=thoat'><div class='fa fa-sign-out'>Log out</div></a>
                        </div>
                        </div>
                        ";

                    }                  
                ?>
            </ul>
      </div>
    </nav>

    <div class='main'>