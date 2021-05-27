<?php

    require_once('../db/dbhelper.php');

    if(!isset($_SESSION["USER_ID"]) || !isset($_GET['id'])) {
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

    
    $oldpassword = $newpasword = $confirmpassword = "";
    $oldpasswordErr = $newpasswordErr = $confirmpasswordErr = "";

    $validated = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $MSKH = $_POST['MSKH'];

        if(empty($_POST["oldpassword"])) {
            $oldpasswordErr = "Hãy nhập mật khẩu cũ của bạn!";
            $validated = false;
        } else $oldpassword = $_POST['oldpassword'];

        if(empty($_POST["newpassword"])) {
            $newpasswordErr = "Hãy nhập mật khẩu mới của bạn!";
            $validated = false;
        } else {          
            if(strlen($_POST["newpassword"]) > 16) {
                $newpasswordErr = "Mật khẩu không được vượt quá 16 ký tự!";
                $validated = false;
            } 
            else $newpassword = $_POST['newpassword']; 
        }

        if(empty($_POST["confirmpassword"])) {
            $confirmpasswordErr = "Hãy xác nhận mật khẩu mới của bạn!";
            $validated = false;
        } else $newpassword = $_POST['confirmpassword'];
        
        if($validated == true) {

            $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$MSKH.'"';
            $result = executeSingle($sql);

            if(password_verify($oldpassword, $result["MatKhau"])) {

                $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);  

                $sql = 'UPDATE KhachHang SET MatKhau = "'.$newpassword.'" WHERE MSKH = "'.$MSKH.'"';  
                execute($sql);

                header('location: profile.php?id='.$MSKH.'');
                die();

            }
            else $oldpasswordErr = "Mật khẩu không đúng!";

        }            

    }

    if(isset($_GET['id'])) {

        if(isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != $_GET['id']) {
            header('location: profile.php?id='.$_SESSION["USER_ID"].'');
            die();
        }

        $MSKH = $_GET['id'];
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
    <link rel="stylesheet" href="../css/ua_sys.css">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/icon.png" sizes="16x16 32x32" type="image/png">
    <title>Đổi Mật Khẩu - HiGamer</title>
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
                                        <a href="../" title="Đăng xuất" onclick="userLogout(); return false;">Đăng xuất <span style="margin-left: 6px;"><i class="fas fa-sign-out-alt"></i></span></a>
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
            <li><a href="profile.php?id=<?=$MSKH?>">THÔNG TIN TÀI KHOẢN</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li>ĐỔI MẬT KHẨU</li>
        </ul>
        
        <div id="main">

            <div class="section">
                <div class="section-title">
                        <h1>Đổi Mật Khẩu</h1>
                </div>
            </div>

            <div id="panel">

                <form method="post" action="password.php?id=<?=$MSKH?>">

                    <input type="hidden" name="MSKH" value="<?php echo $MSKH ?>">

                    <label for="oldpassword">Mật khẩu cũ</label> 
                        <span class="error" id="oldpasswordErr">* <?php echo $oldpasswordErr;?></span>
                    <input type="password" id="oldpassword" name="oldpassword" class="input">

                    <label for="newpassword">Mật khẩu mới</label> 
                        <span class="error" id="newpasswordErr">* <?php echo $newpasswordErr;?></span>
                    <input type="password" id="newpassword" name="newpassword" class="input">

                    <label for="confirmpassword">Xác nhận mật khẩu</label> 
                        <span class="error" id="confirmpasswordErr">* <?php echo $confirmpasswordErr;?></span>
                    <input type="password" id="confirmpassword" name="confirmpassword" class="input">

                    <div id="buttons">
                        <input type="submit" value="Đổi mật khẩu" class="button-reg">
                        <a href="profile.php?id=<?=$MSKH?>"><button type="button" id="button_cancel">Huỷ</button></a>
                    </div>

                </form>

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

        //---------------------------------------------------------------------------
        
        $('#oldpassword').on('keyup', function () {
            $('#oldpasswordErr').html('*');
        });
        $('#newpassword').on('keyup', function () {
            $('#newpasswordErr').html('*');
        });
        $('#confirmpassword').on('keyup', function () {
            $('#confirmpasswordErr').html('*');
        });
        
        $('#newpassword, #confirmpassword').on('keyup', function () {
            $('#newpasswordErr').html('*');
            $('#incorrectPassword').html('*');
            $('.button_main').attr("disabled", false);
            
            if ($('#newpassword').val() != $('#confirmpassword').val()) {
                $('#confirmpasswordErr').html('* Mật khẩu nhập lại Không đúng');
                $('.button_main').attr("disabled", true);
            }

            if (!$('#confirmpassword').val().trim()) {
                $('#confirmpasswordErr').html('* Hãy nhập lại mật khẩu của bạn');
                $('.button_main').attr("disabled", true);
            } 
        });

    </script>
</body>
</html>