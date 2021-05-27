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
    $s1 = '';
    $s2 = '';

    if(!empty($_POST)) {
        if(isset($_POST['maloai'])) {
            $s1 = $_POST['maloai'];
            $s1 = str_replace('"', '\\"', $s1); 
        }
        if(isset($_POST['tenloai'])) {
            $s2 = $_POST['tenloai'];
            $s2 = str_replace('"', '\\"', $s2); 
        }
        
        if(!empty($s1) && !empty($s2)) {
            $sql = 'SELECT * FROM LoaiHangHoa WHERE MaLoaiHang = "'.$s1.'"';
            $result = executeSingle($sql);
            if($result == null) {
                $sql = 'INSERT INTO LoaiHangHoa(MaLoaiHang, TenLoaiHang) 
                        values("'.$s1.'", "'.$s2.'")'
                    ;  
                execute($sql);

                header('location: loaigame.php');
                die();
            }
            else {
                $sql = 'UPDATE LoaiHangHoa SET TenLoaiHang = "'.$s2.'" WHERE MaLoaiHang = "'.$s1.'"';
                execute($sql);

                header('location: loaigame.php');
                die();
            }
        }
    }

    if(isset($_GET['id'])) {
        $s1 = $_GET['id'];
        $sql = 'SELECT * FROM LoaiHangHoa WHERE MaLoaiHang = "'.$s1.'"';
        $result = executeSingle($sql);
        if($result != null) {
            $s2 = $result['TenLoaiHang'];
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
    <title>Thêm/Sửa Loại Game - HiGamer</title>
</head>
<body>
    <div id="container">

        <div id="menu_top">

            <ul id="menu_features">
                <li><a href="loaigame.php" class="last-link">QUAY LẠI</a></li>
            </ul>

        </div>

        <ul class="breadcumb">
            <li><a href="../controlpanel.php">CONTROL PANEL</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li><a href="loaigame.php">QUẢN LÝ LOẠI GAME</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li>THÊM & SỬA THỂ LOẠI GAME</li>
        </ul>

        <div id="menu">

            <div id="logo">
                <img src="../../images/logo.png">
                <h1>THÊM & SỬA THỂ LOẠI GAME</h1>
            </div>

        </div>

        <div id="main"> 

            <div id="panel">

                <form method="post" onsubmit="return confirmChange(<?=$exist?>)">

                    <input type="text" id="maloai" name="maloai" value="<?=$s1?>" placeholder="Mã loại..." title="Mã loại">
                    <input type="text" id="tenloai" name="tenloai" value="<?=$s2?>" placeholder="Tên loại..." title="Tên loại">
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