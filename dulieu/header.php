﻿<?php session_start();header('Content-Type: text/html; charset=UTF-8');require_once("mysql.php"); ?><!DOCTYPE html><html lang="vi"><head>    <title>IA1401 - An Toàn Thông Tin</title>    <meta charset="utf-8">    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    <meta name="viewport" content="width=device-width, initial-scale=1">    <link href="css/bootstrap.min.css" rel="stylesheet">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">    <script src="jquery/jquery.min.js"></script>    <script src="js/bootstrap.min.js"></script>    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    </head><body>    <nav class="navbar navbar-default">        <div class="container-fluid">            <div class="navbar-header">            <a class="navbar-brand" >Chấm bài tự động</a>            </div>            <ul class="nav navbar-nav">                <li <?php if (($_GET["CBHT"])==""){echo 'class="active"';} ?>>                    <a href="./">Trang chủ</a>                </li>                <li <?php if (($_GET["CBHT"])=="rank"){echo 'class="active"';} ?>>                    <a href="./?CBHT=rank">Bảng xếp hạng</a>                </li>                <?php                 if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'] )//fix  Undefined index                {                    echo "<li "; if (($_GET["CBHT"])=="login"){echo 'class="active"';}                    echo"><a href='./login.php?CBHT=login'>Đăng Nhập</a></li>   <li ";                     if (($_GET["CBHT"])=="register"){echo 'class="active"';}                }                else                {                    $user_id = intval($_SESSION['user_id']);                     $sql_query = "SELECT * FROM members WHERE id='{$user_id}'";                     $member1 = $conn->query($sql_query);                     $member = $member1->fetch_assoc();                                        echo "<li "; if (($_GET["CBHT"])=="submit"){echo 'class="active"';} echo"><a href='./submit.php?CBHT=submit'>Nộp bài</a></li>";                     }                ?>            </ul>            <ul class="nav navbar-nav navbar-right">                <?php                     $user_id = intval($_SESSION['user_id']);                    $sql_query = "SELECT * FROM members WHERE id='{$user_id}'";                     $member1 = $conn->query($sql_query);                     $member = $member1->fetch_assoc();                              if($member['Name'] != '') {                        echo "<li><a>Xin chào: {$member['Name']}</a></li>";                        echo "<li><a href='./?CBHT=thoat'>Thoát</a></li>";                      }                                     ?>            </ul>            </div>    </nav>