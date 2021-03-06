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
    $thumbnail = '/images/Covers/unknown.jpg';
    $maloai = $magame = $tengame = $soluong = $gia = $code_category = $content = '';

    if(!empty($_POST)) {
        if(isset($_POST['maloai'])) {
            $maloai = $_POST['maloai'];
            $maloai = str_replace('"', '\\"', $maloai); 
        }
        if(isset($_POST['magame'])) {
            $magame = $_POST['magame'];
            $magame = str_replace('"', '\\"', $magame); 
        }
        if(isset($_POST['tengame'])) {
            $tengame = $_POST['tengame'];
            $tengame = str_replace('"', '\\"', $tengame); 
        }
        if(isset($_POST['soluong'])) {
            $soluong = $_POST['soluong'];
            $soluong = str_replace('"', '\\"', $soluong); 
        }
        if(isset($_POST['gia'])) {
            $gia = $_POST['gia'];
            $gia = str_replace('"', '\\"', $gia); 
        }
        if(isset($_POST['thumbnail'])) {
            $thumbnail = $_POST['thumbnail'];
            $thumbnail = str_replace('"', '\\"', $thumbnail); 
        }
        if(isset($_POST['code_category'])) {
            $code_category = $_POST['code_category'];
            $code_category = str_replace('"', '\\"', $code_category); 
        }
        if(isset($_POST['content'])) {
            $content = $_POST['content'];
            $content = str_replace('"', '\\"', $content); 
        }

        if(!empty($maloai) && !empty($magame) && !empty($tengame) && !empty($soluong) && !empty($gia) && !empty($thumbnail) && !empty($code_category)) {
            $created_at = $updated_at = date('Y-m-d H:i:s');
            $sql = 'SELECT * FROM HangHoa WHERE MSHH = "'.$magame.'"';
            $result = executeSingle($sql);
            if($result == null) {
                $sql = 'INSERT INTO HangHoa(MaLoaiHang, MSHH, TenHH, SoLuongHang, Gia, thumbnail, code_category, GhiChu, created_at, updated_at) 
                            values("'.$maloai.'", "'.$magame.'", "'.$tengame.'", "'.$soluong.'", "'.$gia.'", "'.$thumbnail.'", "'.$code_category.'", 
                            "'.$content.'", "'.$created_at.'", "'.$updated_at.'")';  
                execute($sql);

                header('location: game.php');
                die();
            }
            else {
                $sql = 'UPDATE HangHoa SET MaLoaiHang = "'.$maloai.'", TenHH = "'.$tengame.'", SoLuongHang = "'.$soluong.'", Gia = "'.$gia.'", thumbnail = "'.$thumbnail.'", 
                code_category = "'.$code_category.'", GhiChu = "'.$content.'", updated_at = "'.$updated_at.'" WHERE MSHH = "'.$magame.'"';
                execute($sql);
                header('location: game.php');
                die();
            }
        }
    }

    if(isset($_GET['id'])) {
        $magame = $_GET['id'];
        $sql = 'SELECT * FROM HangHoa WHERE MSHH = "'.$magame.'"';
        $result = executeSingle($sql);
        if($result != null) {
            $maloai = $result['MaLoaiHang'];
            $tengame = $result['TenHH'];
            $soluong = $result['SoLuongHang'];
            $gia = $result['Gia']; 
            $thumbnail = $result['thumbnail'];
            $code_category = $result['code_category'];
            $content = $result['GhiChu'];
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
    <title>Th??m/S???a Game - HiGamer</title>
</head>
<body>
    <div id="container">

        <div id="menu_top">

            <ul id="menu_features">
                <li><a href="game.php" class="last-link">QUAY L???I</a></li>
            </ul>

        </div>

        <ul class="breadcumb">
            <li><a href="../controlpanel.php">CONTROL PANEL</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li><a href="game.php">QU???N L?? GAME</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li>TH??M & S???A GAME</li>
        </ul>

        <div id="menu">

            <div id="logo">
                <img src="../../images/logo.png">
                <h1>TH??M & S???A GAME</h1>
            </div>

        </div>
    
        <div id="main"> 

            <div id="panel">

                <form name="myForm" onsubmit="return validateForm() && confirmChange(<?=$exist?>);" method="post">

                    <select name="code_category" id="code_category">
                    <option value="none">-- CATEGORY --</option>
                    <?php

                        $sql = 'SELECT * FROM category';
                        $gametype = executeResult($sql);
                        foreach($gametype as $item) {
                            if($item['code_category'] == $code_category) {   
                                echo '<option selected value="'.$item['code_category'].'">'.$item['name_category'].'</option>';
                            }
                            else echo '<option value="'.$item['code_category'].'">'.$item['name_category'].'</option>';
                        }

                    ?>
                    </select>

                    <select name="maloai" id="maloai">
                    <option value="none">-- Th??? lo???i --</option>
                    <?php

                        $sql = 'SELECT * FROM LoaiHangHoa';
                        $gametype = executeResult($sql);
                        foreach($gametype as $item) {
                            if($item['MaLoaiHang'] == $maloai) {   
                                echo '<option selected value="'.$item['MaLoaiHang'].'">'.$item['TenLoaiHang'].'</option>';
                            }
                            else echo '<option value="'.$item['MaLoaiHang'].'">'.$item['TenLoaiHang'].'</option>';
                        }

                    ?>
                    </select>
                    <input type="text" id="magame" name="magame" value="<?=$magame?>" placeholder="M?? game..." title="M?? game">
                    <input type="text" id="tengame" name="tengame" value="<?=$tengame?>" placeholder="T??n game..." title="T??n game">
                    <input type="text" id="soluong" name="soluong" value="<?=$soluong?>" placeholder="S??? l?????ng..." title="S??? l?????ng">
                    <input type="text" id="gia" name="gia" value="<?=$gia?>" placeholder="Gi??..." title="Gi??">
                    <textarea id="content" name="content" rows="10" placeholder="N???i dung..."><?=$content?></textarea>
                    <input type="text" id="thumbnail" name="thumbnail" value="<?=$thumbnail?>" placeholder="Thumbnail..." onchange="updateThumbnail()" title="Thumbnail">
                    <img src="<?=$thumbnail?>" style="max-width: 90px;" id="imgThumbnail"> 
                    <input type="submit" value="Submit" class="button-main">

                </form>

            </div>

        </div>

    </div>
    <script>

            function validateForm() {
                var x = document.forms["myForm"]["code_category"].value;
                if (x == "none") {
                    alert("H??y ch???n category!");
                    return false;
                }
                x = document.forms["myForm"]["maloai"].value;
                if (x == "none") {
                    alert("H??y ch???n lo???i game!");
                    return false;
                }
                return true;
            }

            function updateThumbnail() {
                $('#imgThumbnail').attr('src', $('#thumbnail').val());
            }

            function confirmChange(exist) {
                if(exist == true) {
                    var opt = confirm("Warning: D??? li???u ???? t???n t???i! X??c nh???n ch???nh s???a?");
                    if(!opt) return false;
                }
                return true;
            }

    </script>
</body>
</html>