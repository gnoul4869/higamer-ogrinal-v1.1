<?php

    require_once('../../db/dbhelper.php');

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
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/90336495ef.js" crossorigin="anonymous"></script>
    <!-- Open Sans Font -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans"/>
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/admin.css">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../../images/icon.png" sizes="16x16 32x32" type="image/png">
    <title>Loại Game - HiGamer</title>
</head>
<body>
    <div id="container">

        <div id="menu_top">

            <ul id="menu_features">
                <li><a href="../controlpanel.php">CONTROL PANEL</a></li>
                <li><a href="../../" class="last-link">TRANG CHỦ</a></li>
            </ul>

        </div>

        <ul class="breadcumb">
            <li><a href="../controlpanel.php">CONTROL PANEL</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li>QUẢN LÝ LOẠI GAME</li>
        </ul>

        <div id="menu">

            <div id="logo">
                <img src="../../images/logo.png">
                <h1>QUẢN LÝ LOẠI GAME</h1>
            </div>

        </div>
    
        <div id="main">

            <div id="panel"> 

                <?php 
                    $sql = 'SELECT * FROM LoaiHangHoa';
                    $result = executeResult($sql);
                    if($result != null) {
                        echo '
                        <div style="overflow-x:auto;">
                            <table class="info-table">

                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>MÃ LOẠI</th>
                                        <th>TÊN LOẠI</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                $index = 1;
                                foreach($result as $item) {
                                    echo '
                                    <tr>
                                        <td>'.($index++).'</td>
                                        <td>'.$item['MaLoaiHang'].'</td>
                                        <td>'.$item['TenLoaiHang'].'</td>
                                        <td>
                                            <a href="ae_loaigame.php?id='.$item['MaLoaiHang'].'">
                                                <button class="button-edit">Sửa</button>
                                            </a>
                                        </td>
                                        <td>
                                            <button class="button-del" onclick="deleteData(\''.$item['MaLoaiHang'].'\')">Xoá</button>
                                        </td>
                                    </tr>';
                                }
                                echo '
                                </tbody>

                            </table>
                        </div>';
                    } else echo '<div style="font-size: 50px; text-align: center; margin: 100px auto;">Hiện tại không có dữ liệu nào :(</div>'; 
                ?>

                <button class="button-main" onclick="location.href='ae_loaigame.php'">Thêm</button>

            </div>
            
        </div>

    </div>
    <script>

            function deleteData(id) {

                var opt = confirm("Delete this data?");

                if(!opt) return;

                $.post('../../ajax.php', {
                    'id': id,
                    'action': 'deleteLoaiGame'
                }, function(data) {
                    location.reload();
                });
            }

    </script>
</body>
</html>