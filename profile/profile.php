<?php

    require_once('../db/dbhelper.php');

    if(!isset($_SESSION["USER_ID"])) {
        header('location: ../');
        die();
    }

    if(isset($_SESSION["USER_ID"])) {
        $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$_SESSION["USER_ID"].'"';
        $result = executeSingle($sql);
        if($result == null) {
            unset($_SESSION["USER_ID"]);
            header('location: ../');
            die();
        }
    }

    $username = $name = $email = $address = $phone = 'N/A';
    $price = 0;

    if(isset($_GET['id'])) {

        if(isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != $_GET['id']) {
            header('location: profile.php?id='.$_SESSION["USER_ID"].'');
            die();
        }

        $username = $_GET['id'];
        $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$username.'"';
        $result = executeSingle($sql);
        if($result != null) {
            $name = $result['HoTenKH'];
            $email = $result['Email'];
            $phone = $result['SoDienThoai'];
        }

    }

    $cartItem = 0;
    if(isset($_SESSION["USER_ID"]) && isset($_SESSION['CART']) && !empty($_SESSION['CART']))
    {
        foreach($_SESSION['CART'] as $item) {
            $SoLuong = $item['SoLuong'];
            $cartItem += $SoLuong;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["search"])) {
            $search = $_POST["search"];
            if (strlen($search) > 30) {
                $search = substr($search,0,30);
            }
            header('location: ../search.php?id='.$search.'');
            die();
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
    <link rel="stylesheet" href="../css/profile.css">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/icon.png" sizes="16x16 32x32" type="image/png">
    <title>Thông Tin Tài Khoản - HiGamer</title>
</head>
<body>
    <div id="container">

        <div id="menu_top">

            <div id="search_bar">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="text" id="search" name="search" placeholder="Nhập tên game cần tìm..."><button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <ul id="reg_menu">
                <?php
                    $result = null;
                    if(isset($_SESSION["USER_ID"])) {
                        $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$_SESSION["USER_ID"].'"';
                        $result = executeSingle($sql);
                    }
                    if($result != null) {
                        echo '
                            <li>
                                <div class="profile-dropdown">    
                                    <button class="profile-dropbtn">'.$result['HoTenKH'].'</button>
                                    <div class="profile-dropdown-content">
                                        <a href="profile.php?id='.$_SESSION["USER_ID"].'">Thông tin tài khoản</a>
                                        <a href="" title="Đăng xuất" onclick="userLogout(); return false;">Đăng xuất <span style="margin-left: 6px;"><i class="fas fa-sign-out-alt"></i></span></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="../cart.php">
                                    <span id="btn_cart" style="font-weight: bolder;">
                                        <i class="fas fa-shopping-cart"></i> '.$cartItem.'
                                    </span>
                                </a>
                            </li>';
                    } else {
                        echo '<li><a href="../register.php" class="B">ĐĂNG KÝ</a></li>
                              <li><a href="../login.php" class="B">ĐĂNG NHẬP</a></li>';
                    }
                ?> 
            </ul>

        </div>

        <div id="menu">

            <div id="logo">
                <a href="../"><img src="../images/logo.png"></a>
            </div>

            <div id="features">

                <div class="dropdown">    
                    <button class="dropbtn">THỂ LOẠI</button>
                    <div class="dropdown-content">
                    <?php

                        $sql = 'SELECT * FROM LoaiHangHoa';
                        $gametype = executeResult($sql);

                        foreach($gametype as $item) {       
                            echo '
                                <a href="../genre.php?id='.$item["MaLoaiHang"].'">'.$item["TenLoaiHang"].'</a>';
                        }
                    ?>
                    </div>
                </div>
                
                <span id="contact"><a href="../contact.php">LIÊN HỆ</a></span>

            </div>

        </div>

        <ul class="breadcumb">
            <li><a href="../">TRANG CHỦ</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li>THÔNG TIN TÀI KHOẢN</li>
        </ul>
        
        <div id="main">

            <div class="section">
                <div class="section-title">
                        <h1>Thông tin tài khoản</h1> 
                </div>
            </div>

            <div id="detail">

                    <?php
                        echo ' 

                            <div id="info">
                            
                                    <table>
                                        <tr>
                                            <td><span class="info-text">Tên tài khoản:</span></td>
                                            <td>'.$username.'</td>
                                        </tr>
                                        <tr>
                                            <td><span class="info-text">Họ và tên:</span></td>
                                            <td>'.$name.'</td>
                                        </tr>
                                        <tr>
                                            <td><span class="info-text">Email:</span></td>
                                            <td>'.$email.'</td>
                                        </tr>';
                                        $sql = 'SELECT * FROM DiaChiKH WHERE MSKH = "'.$username.'"';
                                        $result = executeResult($sql);

                                        $index = 1;
                                        foreach($result as $item) {
                                            echo '
                                            <tr>
                                                <td><span class="info-text">Địa chỉ '.$index++.':</span></td>
                                                <td>'.$item['DiaChi'].'</td>
                                            </tr>';
                                        }
                                        echo '
                                        <tr>
                                            <td><span class="info-text">Số điện thoại:</span></td>
                                            <td>'.$phone.'</td>
                                        </tr>
                                    </table>
                        
                            </div>
                            
                            <span class="edit-link"><a href="updateprofile.php?id='.$username.'">Cập Nhật Thông Tin Tài Khoản</a></span>
                            <span class="edit-link" style="font-size: 14px; margin-top: 15px;"><a href="password.php?id='.$username.'">Đổi mật khẩu</a></span>';

                        $sql_isAdmin = 'SELECT * FROM NhanVien WHERE MSNV = "'.$username.'"';
                        $isAdmin = executeResult($sql_isAdmin);
                        if($isAdmin != null) echo '<div><a href="../admin/controlpanel.php"><button id="button_cp">Control Panel</button></a></div>';    
                    ?>  

            </div>
    
        </div>

        <div id="footer">
            <div id="copyright">&copy; HiGamer - Designed by gnoul_</div>
        </div>

    </div>
    <!-- JavaScript -->
    <script src="../js/main.js"></script>
    <script>

            ajaxLoaded = false;

            function userLogout() {

                if(ajaxLoaded) return;
                ajaxLoaded = true;

                $.post('../ajax.php', {
                    'action': 'logout'
                }, function(data) {
                    location.reload();
                });
                
            }         

    </script>
</body>
</html>