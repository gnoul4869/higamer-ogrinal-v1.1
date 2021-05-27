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

    
    $HoTenKH = $Email = $address01 = $address02 = $SoDienThoai = $password = "";
    $nameErr = $emailErr = $addressErr = $phoneErr = $passwordErr = $confirm_passwordErr = "";

    $validated = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $MSKH = $_POST['MSKH'];

        if(empty($_POST["password"])) {
            $passwordErr = "Hãy xác nhận mật khẩu của bạn!";
            $validated = false;
        } 
        else {
            $password = $_POST["password"];
            // ---------------------------------------------------------------
            if (empty($_POST["name"])) {
                $nameErr = "Hãy nhập tên của bạn!";
                $validated = false;
            } else {
                $HoTenKH = strip_input($_POST["name"]);
                if (!preg_match
                ("/^([a-zA-Z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i",$HoTenKH)) 
                {
                    $nameErr = "Tên không được chứa ký tự đặc biệt!";
                    $validated = false;
                }
            }
            // ---------------------------------------------------------------
            if (empty($_POST["email"])) {
                $emailErr = "Hãy nhập email của bạn!";
                $validated = false;
            } else {
                $Email = strip_input($_POST["email"]);
                if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Email không đúng chuẩn";
                    $validated = false;
                }
            }
            $sql_e = 'SELECT COUNT(*) AS ECount FROM KhachHang WHERE email = "'.$Email.'"';
            $res_e = executeSingle($sql_e);
            if($res_e['ECount'] > 1) {
                $emailErr = "Email đã tồn tại";
                $validated = false;
            }
            // ---------------------------------------------------------------
            if(empty($_POST["address"])) {
                $addressErr = "Hãy nhập địa chỉ của bạn!";
                $validated = false;
            } else {
                $address01 = strip_input($_POST["address"]);
            }
            if(!empty($_POST["address2"])) {
                $address02 = strip_input($_POST["address2"]);
            }
            // ---------------------------------------------------------------
            if(empty($_POST["phone"])) {
                $phoneErr = "Hãy nhập số điện thoại của bạn!";
                $validated = false;
            } else {
                $SoDienThoai = $_POST["phone"];
            }
            // ---------------------------------------------------------------
            
            if($validated == true) {

                $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$MSKH.'"';
                $result = executeSingle($sql);

                if(password_verify($password, $result["MatKhau"])) {

                    $sql = 'UPDATE KhachHang SET HoTenKH = "'.$HoTenKH.'", Email = "'.$Email.'", SoDienThoai = "'.$SoDienThoai.'" WHERE MSKH = "'.$MSKH.'"';  
                    execute($sql);
        
                    $sql = 'UPDATE DiaChiKH SET DiaChi = "'.$address01.'" WHERE MaDC = "'.$MSKH.'01" AND MSKH = "'.$MSKH.'"';
                    execute($sql);
        
                    if(!empty($address02)) {
                        $sql = 'SELECT * FROM DiaChiKH WHERE MaDC = "'.$MSKH.'02" AND MSKH = "'.$MSKH.'"';
                        $result = executeResult($sql);
                        if($result != null ) {
                            $sql = 'UPDATE DiaChiKH SET DiaChi = "'.$address02.'" WHERE MaDC = "'.$MSKH.'02" AND MSKH = "'.$MSKH.'"';
                            execute($sql);
                        } else {
                            $sql = 'INSERT INTO DiaChiKH(MaDC, MSKH, DiaChi) VALUES("'.$MSKH.'02", "'.$MSKH.'", "'.$address02.'")';
                            execute($sql);
                        }
                    }

                    header('location: profile.php?id='.$MSKH.'');
                    die();

                }
                else $passwordErr = "Mật khẩu không đúng!";

            }
                    
        }

    }

    if(isset($_GET['id'])) {

        if(isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != $_GET['id']) {
            header('location: profile.php?id='.$_SESSION["USER_ID"].'');
            die();
        }

        $MSKH = $_GET['id'];
        $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$MSKH.'"';
        $result = executeSingle($sql);
        if($result != null) {
            $HoTenKH = $result['HoTenKH'];
            $Email = $result['Email'];
                $sql = 'SELECT * FROM DiaChiKH WHERE MaDC = "'.$MSKH.'01" AND MSKH = "'.$MSKH.'"';
                $resultAD = executeSingle($sql);
                $address01 = $resultAD['DiaChi'];
                $sql = 'SELECT * FROM DiaChiKH WHERE MaDC = "'.$MSKH.'02" AND MSKH = "'.$MSKH.'"';
                $resultAD = executeSingle($sql);
                if($resultAD != null) 
                    $address02 = $resultAD['DiaChi'];
            $SoDienThoai = $result['SoDienThoai'];
            $password = $result['MatKhau'];
        }
    }

    function strip_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
    <title>Cập Nhật Thông Tin Tài Khoản - HiGamer</title>
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
            <li>CẬP NHẬT THÔNG TIN TÀI KHOẢN</li>
        </ul>
        
        <div id="main">

            <div class="section">
                <div class="section-title">
                        <h1>Cập nhật thông tin tài khoản</h1>
                </div>
            </div>

            <div id="panel">

                <form method="post" action="updateprofile.php?id=<?=$MSKH?>">

                    <input type="hidden" name="MSKH" value="<?php echo $MSKH ?>">

                    <label for="name">Tên của bạn</label> 
                        <span class="error" id="nameErr">* <?php echo $nameErr;?></span>
                    <input type="text" id="name" name="name" class="input" value="<?=$HoTenKH?>">

                    <label for="email">Email</label> 
                        <span class="error" id="emailErr">* <?php echo $emailErr;?></span>
                    <input type="email" id="email" name="email" class="input" value="<?=$Email?>">

                    <label for="address">Địa chỉ 1 </label> 
                        <span class="error" id="addressErr">* <?php echo $addressErr;?></span>
                    <input type="text" id="address" name="address" class="input" value="<?=$address01?>">

                    <label for="address">Địa chỉ 2</label> 
                        <span class="error" style="color: yellow">(Không bắt buộc)</span>
                    <input type="text" id="address2" name="address2" class="input" value="<?=$address02?>">

                    <label for="phone">Số điện thoại</label> 
                        <span class="error" id="phoneErr">* <?php echo $phoneErr;?></span>
                    <input type="tel" id="phone" name="phone" class="input" pattern="^[0-9-+\s()]*$" value="<?=$SoDienThoai?>">

                    <label for="password">Xác nhận mật khẩu</label> 
                        <span class="error" id="passwordErr">* <?php echo $passwordErr;?></span>
                    <input type="password" id="password" name="password" class="input">

                    <div id="buttons">
                        <input type="submit" value="Cập nhật" class="button-reg"> 
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
        
        $('#username').on('keyup', function () {
            $('#usernameErr').html('*');
        });
        $('#name').on('keyup', function () {
            $('#nameErr').html('*');
        });
        $('#email').on('keyup', function () {
            $('#emailErr').html('*');
        });
        $('#address').on('keyup', function () {
            $('#addressErr').html('*');
        });
        $('#phone').on('keyup', function () {
            $('#phoneErr').html('*');
        });

        $('#password, #confirm_password').on('keyup', function () {
            $('#passwordErr').html('*');
            $('#incorrectPassword').html('*');
            $('.button_main').attr("disabled", false);
            
            if ($('#password').val() != $('#confirm_password').val()) {
                $('#incorrectPassword').html('* Mật khẩu nhập lại Không đúng');
                $('.button_main').attr("disabled", true);
            }

            if (!$('#confirm_password').val().trim()) {
                $('#incorrectPassword').html('* Hãy nhập lại mật khẩu của bạn');
                $('.button_main').attr("disabled", true);
            } 
        });
        

    </script>
</body>
</html>