<?php
    require_once('db/dbhelper.php');

    $username = $password = "";
    $usernameErr = $passwordErr = "";
    $url = "./";

    if(isset($_SERVER['HTTP_REFERER'])) {
        $url = $_SERVER['HTTP_REFERER'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // ---------------------------------------------------------------
        if(empty($_POST["username"])) {
            $usernameErr = "Hãy nhập tên tài khoản của bạn!";
        } else {
            $username = $_POST["username"];
        }
        // ---------------------------------------------------------------
        if(empty($_POST["password"])) {
            $passwordErr = "Hãy nhập mật khẩu của bạn!";
        } else {
            $password = $_POST["password"];
        }
        // ---------------------------------------------------------------
        if(!empty($_POST["username"]) && !empty($_POST["password"])) {
            $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$username.'"';
            $result = executeSingle($sql);
            if($result == null) {
                $usernameErr = "Tài khoản không tồn tại";
            } else {
                if(password_verify($password, $result["MatKhau"])) {

                    $_SESSION["USER_ID"] = $username;
                    if(isset($_POST['rememberMe'])) {
                        // Cookies here
                    }
                    if(isset($_POST['last-url'])) $url = $_REQUEST['last-url'];     
                    header('location:'.$url.'');
                    die();
                    
                }
                else $passwordErr = "Mật khẩu không đúng!";
            }
        }
    }

    $result = null;
    if(isset($_SESSION["USER_ID"])) {
        $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$_SESSION["USER_ID"].'"';
        $result = executeSingle($sql);
        if($result == null) unset($_SESSION["USER_ID"]);
    }
    if($result != null) {
        header('location: ./');
        die();
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
            header('location: search.php?id='.$search.'');
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
    <link rel="stylesheet" href="css/ua_sys.css">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/icon.png" sizes="16x16 32x32" type="image/png">
    <title>Đăng Nhập - HiGamer</title>
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
                                        <a href="profile/profile.php?id='.$_SESSION["USER_ID"].'">Thông tin tài khoản</a>
                                        <a href="." title="Đăng xuất" onclick="userLogout(); return false;">Đăng xuất <span style="margin-left: 6px;"><i class="fas fa-sign-out-alt"></i></span></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="cart.php">
                                    <span id="btn_cart" style="font-weight: bolder;">
                                        <i class="fas fa-shopping-cart"></i> '.$cartItem.'
                                    </span>
                                </a>
                            </li>';
                    } else {
                        echo '<li><a href="register.php" class="B">ĐĂNG KÝ</a></li>
                              <li><a href="login.php" class="B">ĐĂNG NHẬP</a></li>';
                    }
                ?> 
            </ul>

        </div>

        <div id="menu">

            <div id="logo">
                <a href="./"><img src="images/logo.png"></a>
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
                                <a href="genre.php?id='.$item["MaLoaiHang"].'">'.$item["TenLoaiHang"].'</a>';
                        }
                    ?>
                    </div>
                </div>

                <span id="contact"><a href="contact.php">LIÊN HỆ</a></span>

            </div>

        </div>

        <ul class="breadcumb">
            <li><a href="./">TRANG CHỦ</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li>ĐĂNG NHẬP</li>
        </ul>
        
        <div id="main">

            <div class="section">
                <div class="section-title">
                        <h1>Đăng nhập</h1>
                </div>
            </div>

            <div id="panel">

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                    <label for="username">Tài khoản</label> 
                        <span class="error" id="usernameErr">* <?php echo $usernameErr;?></span>
                    <input type="text" id="username" name="username" class="input" value="<?=$username?>">

                    <label for="password">Mật khẩu</label> 
                        <span class="error" id="passwordErr">* <?php echo $passwordErr;?></span>
                    <input type="password" id="password" name="password" class="input">

                    <input type="checkbox" id="rememberMe" name="rememberMe" class="checkbox">
                    <label for="rememberMe">Ghi nhớ đăng nhập</label>

                    <input type="hidden" name="last-url" value="<?=$url?>">

                    <div id="buttons">
                        <input type="submit" value="Đăng nhập" class="button-log">
                        <a href="./"><button type="button" id="button_cancel">Huỷ</button></a>
                    </div>

                </form>
                
                <div id="txt_login">Bạn chưa có tài khoản? Đăng ký <a href="register.php">tại đây</a></div>

            </div>
    
        </div>

        <div id="footer">
            <div id="copyright">&copy; HiGamer - Designed by gnoul_</div>
        </div>

    </div>
    <!-- JavaScript -->
    <script src="js/main.js"></script>
</body>
</html>