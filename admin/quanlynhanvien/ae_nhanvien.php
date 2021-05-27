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
    $MSNV = $HoTenNV = $ChucVu = $DiaChi = $SoDienThoai = '';

    if(!empty($_POST)) {
        if(isset($_POST['MSNV'])) {
            $MSNV = $_POST['MSNV'];
            $MSNV = str_replace('"', '\\"', $MSNV); 
        }
        if(isset($_POST['HoTenNV'])) {
            $HoTenNV = $_POST['HoTenNV'];
            $HoTenNV = str_replace('"', '\\"', $HoTenNV); 
        }
        if(isset($_POST['ChucVu'])) {
            $ChucVu = $_POST['ChucVu'];
            $ChucVu = str_replace('"', '\\"', $ChucVu); 
        }
        if(isset($_POST['DiaChi'])) {
            $DiaChi = $_POST['DiaChi'];
            $DiaChi = str_replace('"', '\\"', $DiaChi); 
        }
        if(isset($_POST['SoDienThoai'])) {
            $SoDienThoai = $_POST['SoDienThoai'];
            $SoDienThoai = str_replace('"', '\\"', $SoDienThoai); 
        }
        
        if(!empty($MSNV) && !empty($HoTenNV) && !empty($ChucVu) && !empty($DiaChi) && !empty($SoDienThoai)) {
            $sql = 'SELECT * FROM NhanVien WHERE MSNV = "'.$MSNV.'"';
            $result = executeSingle($sql);
            if($result == null) {
                $sql = 'INSERT INTO NhanVien(MSNV, HoTenNV, ChucVu, DiaChi, SoDienThoai) 
                        values("'.$MSNV.'", "'.$HoTenNV.'", "'.$ChucVu.'", "'.$DiaChi.'", "'.$SoDienThoai.'")'
                    ;  
                execute($sql);

                header('location: nhanvien.php');
                die();
            }
            else {
                $sql = 'UPDATE NhanVien SET HoTenNV = "'.$HoTenNV.'", ChucVu = "'.$ChucVu.'", DiaChi = "'.$DiaChi.'", SoDienThoai = "'.$SoDienThoai.'" WHERE MSNV = "'.$MSNV.'"';
                execute($sql);

                header('location: nhanvien.php');
                die();
            }
        }
    }

    if(isset($_GET['id'])) {
        $MSNV = $_GET['id'];
        $sql = 'SELECT * FROM NhanVien WHERE MSNV = "'.$MSNV.'"';
        $result = executeSingle($sql);
        if($result != null) {
            $HoTenNV = $result['HoTenNV'];
            $ChucVu = $result['ChucVu'];
            $DiaChi = $result['DiaChi'];
            $SoDienThoai = $result['SoDienThoai'];
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
    <title>Thêm/Sửa Nhân Viên - HiGamer</title>
</head>
<body>
    <div id="container">

        <div id="menu_top">

            <ul id="menu_features">
                <li><a href="nhanvien.php" class="last-link">QUAY LẠI</a></li>
            </ul>

        </div>

        <ul class="breadcumb">
            <li><a href="../controlpanel.php">CONTROL PANEL</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li><a href="nhanvien.php">QUẢN LÝ NHÂN VIÊN</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li>THÊM & SỬA NHÂN VIÊN</li>
        </ul>

        <div id="menu">

            <div id="logo">
                <img src="../../images/logo.png">
                <h1>THÊM & SỬA NHÂN VIÊN</h1>
            </div>

        </div>

        <div id="main"> 

            <div id="panel">

                <form method="post" onsubmit="return confirmChange(<?=$exist?>)">

                    <input type="text" id="MSNV" name="MSNV" value="<?=$MSNV?>" placeholder="Mã nhân viên..." title="Mã nhân viên">                    
                    <input type="text" id="HoTenNV" name="HoTenNV" value="<?=$HoTenNV?>" placeholder="Họ tên..." title="Họ tên">
                    <input type="text" id="ChucVu" name="ChucVu" value="<?=$ChucVu?>" placeholder="Chức vụ..." title="Chức vụ">
                    <input type="text" id="DiaChi" name="DiaChi" value="<?=$DiaChi?>" placeholder="Địa chỉ..." title="Địa chỉ">
                    <input type="tel" id="SoDienThoai" name="SoDienThoai" pattern="^[0-9-+\s()]*$" value="<?=$SoDienThoai?>" placeholder="Số điện thoại..." title="Số điện thoại">
                    <input type="submit" value="Submit" class="button-main">

                </form>

            </div>

        </div>

    </div>
    <script>

        function confirmChange(exist) {
            if(exist == true) {
                var opt = confirm("Warning: Dữ liệu đã tồn tại! Xác nhận chỉnh sửa?");
                if(!opt) return false;
            }
            return true;
        }

    </script>
</body>
</html>