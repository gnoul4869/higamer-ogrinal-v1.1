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
    <title>Quản Lý Đơn Hàng - HiGamer</title>
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
            <li>QUẢN LÝ ĐƠN HÀNG</li>
        </ul>

        <div id="menu">

            <div id="logo">
                <img src="../../images/logo.png">
                <h1>QUẢN LÝ ĐƠN HÀNG</h1>
            </div>

        </div>
        
        <div id="main">

            
                <?php
                        
                    $sql = 'SELECT DatHang.SoDonDH, KhachHang.HoTenKH, DatHang.MSKH, KhachHang.SoDienThoai, KhachHang.Email, DatHang.NgayDH FROM DatHang 
                            INNER JOIN KhachHang ON DatHang.MSKH = KhachHang.MSKH ORDER BY DatHang.SoDonDH';
                    $result = executeResult($sql);
                    if($result != null) {

                        foreach($result as $item_A) {
                            echo ' 
                                <div class=user-info>
                                    <div id="Title">Mã Đơn Hàng: '.$item_A["SoDonDH"].'</div>
                                    <table>
                                        <tr>
                                            <td><span class="info-text">Khách hàng:</span></td>
                                            <td>'.$item_A["HoTenKH"].'</td>
                                        </tr>
                                        <tr>
                                            <td><span class="info-text">Tài khoản:</span></td>
                                            <td>'.$item_A["MSKH"].'</td>
                                        </tr>';
                                        $sql = 'SELECT * FROM DiaChiKH WHERE MSKH = "'.$item_A['MSKH'].'"';
                                        $resultF = executeResult($sql);
                                        $no = 1;
                                        foreach($resultF as $item_F) {
                                        echo '
                                        <tr>
                                            <td><span class="info-text">Địa chỉ '.$no++.':</span></td>
                                            <td>'.$item_F["DiaChi"].'</td>
                                        </tr>';
                                        }
                                        echo '
                                        <tr>
                                            <td><span class="info-text">Số điện thoại:</span></td>
                                            <td>'.$item_A["SoDienThoai"].'</td>
                                        </tr>
                                        <tr>
                                            <td><span class="info-text">Email:</span></td>
                                            <td>'.$item_A["Email"].'</td>
                                        </tr>
                                        <tr>
                                            <td><span class="info-text">Ngày đặt hàng:</span></td>
                                            <td>'.date("d-m-Y H:i:s", strtotime($item_A['NgayDH'])).'</td>
                                        </tr>
                                    </table>
                                </div>
                                    <div id="panel"> 
                                        <div style="overflow-x:auto;">
                                            <table class="info-table">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>MÃ SP</th>                             
                                                        <th>TÊN SP</th>
                                                        <th>THUMBNAIL</th>
                                                        <th>ĐƠN GIÁ</th>
                                                        <th>SỐ LƯỢNG</th>
                                                        <th>SỐ TIỀN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                $sql = 'SELECT ChiTietDatHang.MSHH, HangHoa.TenHH, HangHoa.thumbnail, ChiTietDatHang.Gia, ChiTietDatHang.SoLuong, ChiTietDatHang.GiaDatHang FROM ChiTietDatHang
                                                        INNER JOIN HangHoa ON ChiTietDatHang.MSHH = HangHoa.MSHH WHERE ChiTietDatHang.SoDonDH = '.$item_A["SoDonDH"].'';
                                                $detail = executeResult($sql);
                                                $index = 1;
                                                $totalPrice = 0;
                                                $totalItem = 0;
                                                foreach($detail as $item_B) {
                                                $totalItem += $item_B['SoLuong'];
                                                $totalPrice += $item_B['GiaDatHang'] * $item_B['SoLuong'];
                                                echo '
                                                    <tr>
                                                        <td>'.($index++).'</td>
                                                        <td>'.$item_B['MSHH'].'</td>
                                                        <td>'.$item_B['TenHH'].'</td>
                                                        <td><img src="'.$item_B['thumbnail'].'" style="max-width: 90px;"></td>                              
                                                        <td>'.number_format($item_B['Gia'], 0, ',', '.').'₫</td>
                                                        <td>'.$item_B['SoLuong'].'</td>
                                                        <td>'.number_format(($item_B['GiaDatHang'] * $item_B['SoLuong']), 0, ',', '.').'₫</td>
                                                    </tr>';
                                                }

                                                echo '
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="Total">Tổng Thanh Toán ('.$totalItem.' Sản Phẩm): <span style="color: #ffffa7">'.number_format($totalPrice, 0, ',', '.').'₫</span></div>
                                    <button class="button-main" style="color: #ffffa7;" onclick="confirmDH(\''.$item_A["SoDonDH"].'\')">Hoàn Tất</button>
                                    <hr style="margin: 30px 0;">';
                        }
                        
                    }
                    else echo '<div style="font-size: 50px; text-align: center; margin: 100px auto;">Hiện tại không có đơn hàng nào :(</div>';
                ?>

            </div>
                 
    </div>
    <script>

            function confirmDH(id) {

                var opt = confirm("Xác nhận hoàn tất đơn hàng " + id + "?");

                if(!opt) return;

                $.post('../../ajax.php', {
                    'id': id,
                    'action': 'confirmDH'
                }, function(data) {
                    location.reload();
                });
            }
            
    </script>
</body>
</html>