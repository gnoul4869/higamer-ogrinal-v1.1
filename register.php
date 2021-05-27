<?php

    require_once('db/dbhelper.php');

    $_SESSION['REGISTER'] = false;
    $validated = true;

    $username = $name = $email = $address = $address2 = $phone = $password = $confirm_password = "";
    $usernameErr = $nameErr = $emailErr = $addressErr = $phoneErr = $passwordErr = $confirm_passwordErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // ---------------------------------------------------------------
        if (empty($_POST["username"])) {
            $usernameErr = "Hãy nhập tên tài khoản của bạn!";
            $validated = false;
        } else {
            $username = $_POST["username"];
            if (strlen($username) > 20) {
                $usernameErr = "Tên đăng nhập không được vượt quá 20 ký tự!";
                $validated = false;
            }
        }
        $sql_u = 'SELECT * FROM KhachHang WHERE MSKH = "'.$username.'"';
        $res_u = executeSingle($sql_u);
        if($res_u != null) {
            $usernameErr = "Tài khoản đã tồn tại";
            $validated = false;
        }
        // ---------------------------------------------------------------
        if (empty($_POST["name"])) {
            $nameErr = "Hãy nhập tên của bạn!";
            $validated = false;
        } else {
            $name = strip_input($_POST["name"]);
            if (!preg_match
            ("/^([a-zA-Z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i",$name)) 
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
            $email = strip_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Email không đúng chuẩn";
                $validated = false;
            }
        }
        $sql_e = 'SELECT * FROM KhachHang WHERE email = "'.$email.'"';
        $res_e = executeSingle($sql_e);
        if($res_e != null) {
            $emailErr = "Email đã tồn tại";
            $validated = false;
        }
        // ---------------------------------------------------------------
        if(empty($_POST["address"])) {
            $addressErr = "Hãy nhập địa chỉ của bạn!";
            $validated = false;
        } else {
            $address = strip_input($_POST["address"]);
        }
        if(!empty($_POST["address2"])) {
            $address2 = strip_input($_POST["address2"]);
        }
        // ---------------------------------------------------------------
        if(empty($_POST["phone"])) {
            $phoneErr = "Hãy nhập số điện thoại của bạn!";
            $validated = false;
        } else {
            $phone = $_POST["phone"];
        }
        // ---------------------------------------------------------------
        if(empty($_POST["password"])) {
            $passwordErr = "Hãy nhập mật khẩu của bạn!";
            $validated = false;
        } else {            
            if(strlen($_POST["password"]) > 16) {
                $passwordErr = "Mật khẩu không được vượt quá 16 ký tự!";
                $validated = false;
            } 
            else $password = password_hash($_POST["password"], PASSWORD_DEFAULT);  
        }
        // ---------------------------------------------------------------
        if(empty($_POST["confirm_password"])) {
            $confirm_passwordErr = "Hãy nhập lại mật khẩu của bạn!";
            $validated = false;
        } 
        // ---------------------------------------------------------------
        if($validated == true) {

            $sql = 'INSERT INTO KhachHang(MSKH, HoTenKH, Email, SoDienThoai, MatKhau) 
                        VALUES("'.$username.'", "'.$name.'", "'.$email.'", "'.$phone.'", "'.$password.'")';  
            execute($sql);

            $sql = 'INSERT INTO DiaChiKH(MaDC, MSKH, DiaChi) VALUES("'.$username.'01", "'.$username.'", "'.$address.'")';
            execute($sql);

            if(!empty($address2)) {
                $sql = 'INSERT INTO DiaChiKH(MaDC, MSKH, DiaChi) VALUES("'.$username.'02", "'.$username.'", "'.$address2.'")';
                execute($sql);
            }

            $_SESSION['REGISTER'] = true;
                
        }
    }

    function strip_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
    <title>Đăng Ký Thành Viên - HiGamer</title>
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
            <li>ĐĂNG KÝ THÀNH VIÊN</li>
        </ul>
        
        <div id="main">

            <div class="section">
                <div class="section-title">
                        <h1>Đăng ký thành viên</h1>
                </div>
            </div>

            <div id="panel">

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                    <label for="username">Tên tài khoản</label> 
                        <span class="error" id="usernameErr">* <?php echo $usernameErr;?></span>
                    <input type="text" id="username" name="username" class="input" value="<?=$username?>">

                    <label for="name">Tên của bạn</label> 
                        <span class="error" id="nameErr">* <?php echo $nameErr;?></span>
                    <input type="text" id="name" name="name" class="input" value="<?=$name?>">

                    <label for="email">Email</label> 
                        <span class="error" id="emailErr">* <?php echo $emailErr;?></span>
                    <input type="email" id="email" name="email" class="input" value="<?=$email?>">

                    <label for="address">Địa chỉ 1 </label> 
                        <span class="error" id="addressErr">* <?php echo $addressErr;?></span>
                    <input type="text" id="address" name="address" class="input" value="<?=$address?>">

                    <label for="address">Địa chỉ 2</label> 
                        <span class="error" style="color: yellow">(Không bắt buộc)</span>
                    <input type="text" id="address2" name="address2" class="input" value="<?=$address2?>">

                    <label for="phone">Số điện thoại</label> 
                        <span class="error" id="phoneErr">* <?php echo $phoneErr;?></span>
                    <input type="tel" id="phone" name="phone" class="input" pattern="^[0-9-+\s()]*$" value="<?=$phone?>">

                    <label for="password">Mật khẩu</label> 
                        <span class="error" id="passwordErr">* <?php echo $passwordErr;?></span>
                    <input type="password" id="password" name="password" class="input">

                    <label for="password2">Nhập lại mật khẩu</label> 
                        <span class="error"  id="incorrectPassword">* <?php echo $confirm_passwordErr;?></span>
                    <input type="password" id="confirm_password" name="confirm_password" class="input">

                    <div id="buttons">
                        <input type="submit" value="Đăng ký" class="button-reg">
                        <a href="./"><button type="button" id="button_cancel">Huỷ</button></a>
                    </div>

                </form>
                
                <div id="txt_login">Bạn đã có tài khoản? Đăng nhập <a href="login.php">tại đây</a></div>

            </div>
    
        </div>

        <div id="footer">
            <div id="copyright">&copy; HiGamer - Designed by gnoul_</div>
        </div>

        <div id="modal">
            <div id="modal_content">
                <h3>Đăng ký thành công! Nhấn vào đây để đăng nhập.</h3>
                    <a href="login.php"><button id="button_ok">Đăng nhập</button></a>
            </div>
        </div>

    </div>
    <!-- PHP -->
    <?php
        if(isset($_SESSION['REGISTER']) && $_SESSION['REGISTER'] == true) {
            echo '<script> 
                    $("#modal").css("display", "flex");
                    $("body").css("overflow", "hidden");
            </script>';
            $_SESSION['REGISTER'] = '';
        }
    ?>
    <!-- JavaScript -->
    <script src="js/main.js"></script>
    <script>
        
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

        //---------------------------------------------------------------------------
        
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