<?php

    require_once('../db/dbhelper.php');
    
    $isAdmin = null;
    if(isset($_SESSION["USER_ID"])) {
        $sql_isAdmin = 'SELECT * FROM NhanVien WHERE MSNV = "'.$_SESSION["USER_ID"].'"';
        $isAdmin = executeResult($sql_isAdmin);
    }
    if(!isset($_SESSION["USER_ID"]) || $isAdmin == null) {
        header('location: ../../');
        die();
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Open Sans Font -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans"/>
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/icon.png" sizes="16x16 32x32" type="image/png">
    <title>Control Panel - HiGamer</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-image: url("/images/texture_grid.png"), url("/images/Backgrounds/space.jpg");
            background-repeat: repeat, no-repeat; 
            background-size: 0.21%, cover;
            background-attachment: fixed;
            transition: 1s ease-in-out;
            color: white;
        }
        #container {
            padding: auto;
            height: auto;
            max-width: 1140px;
            margin: 10% auto;
            background: #161c20;
        }
        #menu_top {
            height: 50px;
            position: sticky;
            top: 0;
            background-color: #161c20;
            border-top: 2px solid #e44444;
            border-bottom: 2px solid #e44444;
        }
        #menu_top #menu_features {
            list-style-type: none;
            padding: 0;
            margin-top: 14px;
            float: left;
        }
        #menu_top #menu_features a, a.visited {
            color: white;
            border-color: #e44444;
        }
        #menu_top #menu_features li {
            display: inline;
        }
        #menu_top #menu_features li a:link {
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.2px;
            padding: 0 20px 0 16px;
            margin: 0;
            border-right: 2px solid #e44444;
            color: white;
        }
        #menu_top #menu_features li a:link.last-link {
            border-right: 0px;
        }
        #menu_top #menu_features li a:hover {
            color: #e44444;
        }
        #menu_top #exit {
            display: inline;
            float: right;
            text-decoration: none;
            margin: 15px 15px 0 0;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.2px;
            color: white;
        }
        #menu_top #exit:hover {
            color: #e44444;
        }
        #main {
            border-bottom: 1px solid #e44444;
            width: 100%;
            height: 500px;
            background: #161c20;
        }
        #main #logo {
            left: 0;
            right: 0;
            text-align: center;

        }
        #main #logo img {
            height: 80%;
            width: 80%;
        }
        #main #logo h1 {
            font-weight: bolder;
            font-stretch: ultra-expanded;
            font-size: 120px;
            line-height: 10px;
        }
    </style>
</head>
<body>
    <div id="container">

        <div id="menu_top">

            <ul id="menu_features">
                <li><a href="category/category.php">DANH MỤC</a></li>
                <li><a href="quanlyloaigame/loaigame.php">THỂ LOẠI</a></li>
                <li><a href="quanlygame/game.php">KHO GAME</a></li>
                <li><a href="quanlythanhvien/thanhvien.php">THÀNH VIÊN</a></li>
                <li><a href="quanlynhanvien/nhanvien.php">NHÂN VIÊN</a></li>
                <li><a href="quanlydonhang/donhang.php" class="last-link">ĐƠN HÀNG</a></li>
            </ul>
            <a href="../" id="exit">THOÁT</a>

        </div>

        <div id="main">

            <div id="logo">
                <img src="../images/logo.png">
                <h1>CONTROL PANEL</h1>
            </div>

        </div>
    
    </div>   
</body>
</html>