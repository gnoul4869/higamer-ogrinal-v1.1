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
    <title>Kho Game - HiGamer</title>
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
            <li>QUẢN LÝ GAME</li>
        </ul>

        <div id="menu">

            <div id="logo">
                <img src="../../images/logo.png">
                <h1>QUẢN LÝ GAME</h1>
            </div>

        </div>
    
        <div id="main">

            <div id="panel"> 

                <?php 
                    $sql = 'SELECT HangHoa.MSHH, LoaiHangHoa.TenLoaiHang, HangHoa.TenHH, HangHoa.SoLuongHang, HangHoa.Gia, HangHoa.thumbnail, category.name_category, HangHoa.updated_at 
                                FROM HangHoa INNER JOIN LoaiHangHoa ON HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang
                                                INNER JOIN category ON HangHoa.code_category = category.code_category
                                                    ORDER BY HangHoa.MSHH ASC';
                    $result = executeResult($sql);
                    if($result != null) {
                        echo '
                        <div style="overflow-x:auto;">
                            <table class="info-table">

                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>MÃ</th>
                                        <th>THỂ LOẠI</th>                                
                                        <th>TÊN</th>
                                        <th>Số LƯỢNG</th>
                                        <th>GIÁ</th>
                                        <th>THUMBNAIL</th>
                                        <th>CATEGORY</th>
                                        <th>NGÀY CẬP NHẬT</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                
                                $index = 1;
                                foreach($result as $item) {
                                    echo
                                    '<tr>
                                        <td>'.($index++).'</td>
                                        <td>'.$item['MSHH'].'</td>
                                        <td>'.$item['TenLoaiHang'].'</td>                                    
                                        <td>'.$item['TenHH'].'</td>
                                        <td>'.$item['SoLuongHang'].'</td>
                                        <td>'.number_format($item['Gia'], 0, ',', '.').'₫</td>
                                        <td><img src="'.$item['thumbnail'].'" style="max-width: 90px;"></td>
                                        <td>'.$item['name_category'].'</td>
                                        <td>'.date("d-m-y g:i A", strtotime($item['updated_at'])).'</td>
                                        <td>
                                            <a href="ae_game.php?id='.$item['MSHH'].'">
                                                <button class="button-edit">Sửa</button>
                                            </a>
                                        </td>
                                        <td>
                                            <button class="button-del" onclick="deleteData(\''.$item['MSHH'].'\')">Xoá</button>
                                        </td>
                                    </tr>';
                                }
                                echo '
                                </tbody>

                            </table>
                        </div>';

                    } else echo '<div style="font-size: 50px; text-align: center; margin: 100px auto;">Hiện tại không có dữ liệu nào :(</div>'; 
                ?>

                <button class="button-main" onclick="location.href='ae_game.php'">Thêm</button>

            </div>
            
        </div>

    </div>
    <script>

            function deleteData(id) {

                var opt = confirm("Delete this data?");

                if(!opt) return;

                $.post('../../ajax.php', {
                    'id': id,
                    'action': 'deleteGame'
                }, function(data) {
                    location.reload();
                });
            }
            
    </script>
</body>
</html>