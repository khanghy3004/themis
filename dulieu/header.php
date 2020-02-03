﻿<?php 
session_start();
header('Content-Type: text/html; charset=UTF-8');
require_once("mysql.php"); 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Themis</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js"></script>
    <script src="jquery/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
            <a class="navbar-brand" >Chấm bài tự động</a>
            </div>
            <ul class="nav navbar-nav">
                <li <?php if (($_GET["CBHT"])==""){echo 'class="active"';} ?>>
                    <a href="./">HOME</a>
                </li>
                <li <?php if (($_GET["CBHT"])=="rank"){echo 'class="active"';} ?>>
                    <a href="./?CBHT=rank">RANK</a>
                </li>
                <li <?php if (($_GET["CBHT"])=="help"){echo 'class="active"';} ?>>
                    <a href="./?CBHT=help">HELP</a>
                </li>
                <li>
                    <a href="./corona.php">CORONA</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                 <?php 
                if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'] )//fix  Undefined index
                {
                    echo "<li "; if (($_GET["CBHT"])=="login"){echo 'class="active"';}
                    echo"><a class='fa fa-sign-in' href='./?CBHT=login'> LOG IN</a></li>   <li "; 
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
                        <a class='fa fa-upload' href='./?CBHT=submit'> SUBMIT</a></li>";   
                    } 

                    $user_id = intval($_SESSION['user_id']);
                    $sql_query = "SELECT * FROM members WHERE id='{$user_id}'"; 
                    $member1 = $conn->query($sql_query); 
                    $member = $member1->fetch_assoc();          
                    if($member['Name'] != '') {
                        echo "

                        <li class=dropdown><a data-toggle=dropdown href=>{$member['Name']}<span class=caret></span></a>
                            <ul class=dropdown-menu>
                              <li><a class='fa fa-refresh' href='./?CBHT=edit'> Change password</a></li>
                              "?> <?php if ($_SESSION['user_admin'] == 1) 
                                {
                                    echo "<li><a class='fa fa-edit' href='./?CBHT=time'> Edit contest</a></li>
                                    <li "; if (($_GET["CBHT"])=="register"){echo 'class="active"';} echo"><a class='fa fa-user' href='./?CBHT=register'> Add User</a></li>";           
                                }?>
                                <?php echo
                              "
                                <li class='divider'></li>
                                <li><a class='fa fa-sign-out' href='./?CBHT=thoat'> Log out</a></li>
                            </ul>
                        </li>

                        ";

                    }                  
                ?>
            </ul>    
        </div>
    </nav>
    <div class='main'>