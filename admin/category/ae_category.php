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
        if(isset($_POST['code_category'])) {
            $s1 = $_POST['code_category'];
            $s1 = str_replace('"', '\\"', $s1); 
        }
        if(isset($_POST['name_category'])) {
            $s2 = $_POST['name_category'];
            $s2 = str_replace('"', '\\"', $s2); 
        }
        
        if(!empty($s1) && !empty($s2)) {
            $sql = 'SELECT * FROM category WHERE code_category = "'.$s1.'"';
            $result = executeSingle($sql);
            if($result == null) {
                $sql = 'INSERT INTO category(code_category, name_category) values("'.$s1.'", "'.$s2.'")';  
                execute($sql);

                header('location: category.php');
                die();
            }
            else {
                $sql = 'UPDATE category SET name_category = "'.$s2.'" WHERE code_category = "'.$s1.'"';
                execute($sql);

                header('location: category.php');
                die();
            }
        }
    }

    if(isset($_GET['id'])) {
        $s1 = $_GET['id'];
        $sql = 'SELECT * FROM category WHERE code_category = "'.$s1.'"';
        $result = executeSingle($sql);
        if($result != null) {
            $s2 = $result['name_category'];
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
    <title>Thêm/Sửa Danh Mục - HiGamer</title>
</head>
<body>
    <div id="container">

        <div id="menu_top">

            <ul id="menu_features">
                <li><a href="category.php" class="last-link">QUAY LẠI</a></li>
            </ul>

        </div>

        <ul class="breadcumb">
            <li><a href="../controlpanel.php">CONTROL PANEL</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li><a href="category.php">QUẢN LÝ DANH MỤC</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li>THÊM & SỬA DANH MỤC</li>
        </ul>

        <div id="menu">

            <div id="logo">
                <img src="../../images/logo.png">
                <h1>THÊM & SỬA DANH MỤC</h1>
            </div>

        </div>

        <div id="main"> 

            <div id="panel">

                <form method="post" onsubmit="return confirmChange(<?=$exist?>)">

                    <input type="text" id="code_category" name="code_category" value="<?=$s1?>" placeholder="Code (3)..." title="Code (3)">
                    <input type="text" id="name_category" name="name_category" value="<?=$s2?>" placeholder="Name (60)..." title="Name (60)">
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