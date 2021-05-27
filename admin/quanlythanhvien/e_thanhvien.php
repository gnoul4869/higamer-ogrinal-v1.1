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

    $exist = false;
    $s1 = $s2 = $s3 = $s4 = $s5 = $s6 = '';

    if(!empty($_POST)) {
        if(isset($_POST['MSKH'])) {
            $s1 = $_POST['MSKH'];
            $s1 = str_replace('"', '\\"', $s1); 
        }
        if(isset($_POST['HoTenKH'])) {
            $s2 = $_POST['HoTenKH'];
            $s2 = str_replace('"', '\\"', $s2); 
        }
        if(isset($_POST['Email'])) {
            $s3 = $_POST['Email'];
            $s3 = str_replace('"', '\\"', $s3); 
        }
        if(isset($_POST['SoDienThoai'])) {
            $s4 = $_POST['SoDienThoai'];
            $s4 = str_replace('"', '\\"', $s4); 
        }
        if(isset($_POST['DiaChi1'])) {
            $s5 = $_POST['DiaChi1'];
            $s5 = str_replace('"', '\\"', $s5); 
        }
        if(isset($_POST['DiaChi2'])) {
            $s6 = $_POST['DiaChi2'];
            $s6 = str_replace('"', '\\"', $s6); 
        }

        if(!empty($s1) && !empty($s2) && !empty($s3) && !empty($s4) && !empty($s5)) {
            $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$s1.'"';
            $result = executeSingle($sql);
            if($result != null) {
                $sql = 'UPDATE KhachHang SET HoTenKH = "'.$s2.'", Email = "'.$s3.'", SoDienThoai = "'.$s4.'"   WHERE MSKH = "'.$s1.'"';
                execute($sql);

                $sql = 'UPDATE DiaChiKH SET DiaChi = "'.$s5.'" WHERE MaDC = "'.$s1.'01" AND MSKH = "'.$s1.'"';
                execute($sql);
    
                if(!empty($s6)) {
                    $sql = 'SELECT * FROM DiaChiKH WHERE MaDC = "'.$s1.'02" AND MSKH = "'.$s1.'"';
                    $result = executeResult($sql);
                    if($result != null ) {
                        $sql = 'UPDATE DiaChiKH SET DiaChi = "'.$s6.'" WHERE MaDC = "'.$s1.'02" AND MSKH = "'.$s1.'"';
                        execute($sql);
                    } else {
                        $sql = 'INSERT INTO DiaChiKH(MaDC, MSKH, DiaChi) VALUES("'.$s1.'02", "'.$s1.'", "'.$s6.'")';
                        execute($sql);
                    }
                }

                header('location: thanhvien.php');
                die();
            }
        }
    }

    if(isset($_GET['id'])) {
        $s1 = $_GET['id'];
        $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$s1.'"';
        $result = executeSingle($sql);
        if($result != null) {
            $s2 = $result['HoTenKH'];
            $s3 = $result['Email']; 
            $s4 = $result['SoDienThoai'];
            $sql = 'SELECT * FROM DiaChiKH WHERE MaDC = "'.$s1.'01" AND MSKH = "'.$s1.'"';
                $resultAD = executeSingle($sql);
                $s5 = $resultAD['DiaChi'];
                $sql = 'SELECT * FROM DiaChiKH WHERE MaDC = "'.$s1.'02" AND MSKH = "'.$s1.'"';
                $resultAD = executeSingle($sql);
                if($resultAD != null) 
                    $s6 = $resultAD['DiaChi'];
            $exist = true;
        }
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
    <title>Sửa Thông Tin Thành Viên - HiGamer</title>
</head>
<body>
    <div id="container">

        <div id="menu_top">

            <ul id="menu_features">
                <li><a href="thanhvien.php" class="last-link">QUAY LẠI</a></li>
            </ul>

        </div>

        <ul class="breadcumb">
            <li><a href="../controlpanel.php">CONTROL PANEL</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li><a href="thanhvien.php">QUẢN LÝ THÀNH VIÊN</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li>SỬA THÔNG TIN THÀNH VIÊN</li>
        </ul>

        <div id="menu">

            <div id="logo">
                <img src="../../images/logo.png">
                <h1>SỬA THÔNG TIN THÀNH VIÊN</h1>
            </div>

        </div>
    
        <div id="main"> 

            <div id="panel">

                <form name="myForm" onsubmit="return confirmChange(<?=$exist?>)" method="post">

                    <input type="text" id="MSKH" name="MSKH" value="<?=$s1?>" title="Tài khoản">
                    <input type="text" id="HoTenKH" name="HoTenKH" value="<?=$s2?>" title="Họ tên">
                    <input type="text" id="Email" name="Email" value="<?=$s3?>" title="Email">        
                    <input type="tel" id="SoDienThoai" name="SoDienThoai" pattern="^[0-9-+\s()]*$"  value="<?=$s4?>" title="Số điện thoại">
                    <input type="text" id="DiaChi1" name="DiaChi1" value="<?=$s5?>" title="Địa chỉ 1">
                    <input type="text" id="DiaChi2" name="DiaChi2" value="<?=$s6?>" title="Địa chỉ 2">
                    <input type="submit" value="Submit" class="button-main">

                </form>

            </div>

        </div>

    </div>
    <script>
    
        function confirmChange(exist) {
            if(exist == true) {
                var opt = confirm("Xác nhận chỉnh sửa?");
                if(!opt) return false;
            }
            return true;
        }

    </script>
</body>
</html>