<?php

    require_once('db/dbhelper.php');

    $id = $name = $genre = $updated_at = $content = 'N/A';
    $price = 0;
    $thumbnail = '/images/Game-covers/unknown.jpg';
    $avail = '<span style="color: red">Hết Hàng</span>';
    $inStock = false;

    if(isset($_GET['id'])) {

        $id = $_GET['id'];
        $sql = 'SELECT DISTINCT HangHoa.TenHH, LoaiHangHoa.TenLoaiHang, HangHoa.Gia, HangHoa.thumbnail, HangHoa.SoLuongHang, HangHoa.updated_at, HangHoa.GhiChu 
                FROM HangHoa INNER JOIN LoaiHangHoa ON HangHoa.MSHH = "'.$id.'" AND HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang';
        $result = executeSingle($sql);
        if($result != null) {
            $thumbnail = $result['thumbnail'];
            $name = $result['TenHH'];
            $genre = $result['TenLoaiHang'];
            $price = $result['Gia'];
            if($result['SoLuongHang'] > 0) {
                $avail = '<span style="color: green">Còn Hàng</span>';
                $inStock = true;
            }
            $updated_at = date("d-m-Y", strtotime($result['updated_at']));
            $content = $result['GhiChu'];
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
            header('location: search.php?id='.$search.'');
            die();
        }
    }

    if(!isset($_SESSION["USER_ID"])) $login = 0;
    else $login = 1;

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
    <link rel="stylesheet" href="css/item.css">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/icon.png" sizes="16x16 32x32" type="image/png">
    <title><?=$name?> - HiGamer</title>
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
            <li><a href="games.php">GAMES</a></li>
            <li><span style="color: grey"><i class="fas fa-angle-right"></i></span></li>
            <li><?=$name?></li>
        </ul>
        
        <div id="main">

            <div id="detail">

                    <?php
                        echo ' 

                        <div id="thumbnail">
                                <img src="'.$thumbnail.'" style="width: 280px; height: 320px;">
                        </div>

                        <div id="right">
                                
                            <div id="info">
                            
                                <div id="gameTitle">'.$name.'</div>
                                <div id="shopper">
                                    <table>
                                        <tr>
                                            <td><span style="color: white">Thể loại:</span></td>
                                            <td>'.$genre.'</td>
                                        </tr>
                                        <tr>
                                            <td><span style="color: white">Giá sản phẩm:</span></td>
                                            <td>'.number_format($price, 0, ',', '.').'₫</td>
                                        </tr>
                                        <tr>
                                            <td><span style="color: white">Tình trạng:</span></td>
                                            <td>'.$avail.'</td>
                                        </tr>
                                        <tr>
                                            <td><span style="color: white">Ngày cập nhật:</span></td>
                                            <td>'.$updated_at.'</td>
                                        </tr>
                                    </table>

                                    <div id="buttons">
                                        <button id="button_buy" onclick="confirmItem()">MUA NGAY</button>
                                        <button id="button_cart" onclick="addToCart(\''.$id.'\', 1)">THÊM VÀO GIỎ <i class="fas fa-cart-plus"></i></button>
                                    </div>
                                </div>

                            </div>
                        
                        </div>';

                    ?>       

            </div>


            <div id="content">
                    <p><?=$content?></p>
            </div> 
    
        </div>

        <div id="footer">
            <div id="copyright">&copy; HiGamer - Designed by gnoul_</div>
        </div>

        <div id="modal">
            <div id="modal_content">
                <?php
                        if(!isset($_SESSION['USER_ID'])) {
                            echo '
                                <h3>Hãy đăng nhập tài khoản trước khi mua hàng!</h3>
                                <div id="modal_button">
                                    <a href="login.php"><button id="button_login">Đăng nhập</button></a>
                                    <button id="button_cancel" onclick="cancelItem()">Huỷ</button>
                                </div>';
                        }
                        else if(isset($_SESSION['PURCHASED']) && $_SESSION['PURCHASED'] == true) {
                            echo '
                                <h3 style="color: #ffffa7">Cảm ơn bạn đã mua hàng tại HiGamer :D</h3>
                                <p style="margin-bottom: 30px;">Bạn vui lòng chờ nhân viên liên hệ để xác nhận thanh toán trong vòng 24H!</p>
                                <a href=""><button id="button_ok">OK</button></a>';
                        }
                        else if(isset($_SESSION['CART_ADDED']) && $_SESSION['CART_ADDED'] == true) {
                            echo '
                                <h3 style="font-size: 21px; color: #ffffa7; margin-bottom: 40px;">Đã thêm vào giỏ hàng!</h3>
                                <a href=""><button id="button_ok">OK</button></a>';
                        }
                        else if(isset($_SESSION['USER_ID'])) {
                                echo '
                                    <h3>Xác nhận mua hàng?</h3>
                                    <p><span style="color: #e44444; font-weight: bolder;"> '.$name.'</span></p>
                                    <p>Giá sản phẩm:<span style="color: #ffffa7"> '.number_format($price, 0, ',', '.').'₫</span></p>
                                    <div id="modal_button">
                                        <button id="button_ok" onclick="buyItem(\''.$id.'\', 1)">Mua Hàng</button>
                                        <button id="button_cancel" onclick="cancelItem()">Huỷ</button>
                                    </div>';
                        }
                    ?>
            </div>
        </div>

    </div>
    <!-- PHP -->
    <?php
        if(isset($_SESSION['PURCHASED']) && $_SESSION['PURCHASED'] == true) {
            echo '
            <script> 
                $("#modal").css("display", "flex");
                $("body").css("overflow", "hidden");
            </script>';
            $_SESSION['PURCHASED'] = '';
        }
        if(isset($_SESSION['CART_ADDED']) && $_SESSION['CART_ADDED'] == true) {
            echo '
            <script> 
                $("#modal").css("display", "flex");
                $("body").css("overflow", "hidden");
            </script>';
            $_SESSION['CART_ADDED'] = '';
        }
        if($inStock == false) {
            echo '<script> 
                $("#button_buy").attr("disabled", true);
                $("#button_cart").attr("disabled", true);
            </script>;';
        }
    ?>
    <!-- JavaScript -->
    <script src="js/main.js"></script>
    <script>

            var ajaxLoaded = false;

            function confirmItem() {
                $("#modal").css("display", "flex");
                $("body").css("overflow", "hidden");
            }

            function cancelItem() {
                $("#modal").css("display", "none");
                $("body").css("overflow", "auto");
            }

            function buyItem(id, amount) {
                
                if(ajaxLoaded) return;
                ajaxLoaded = true;

                $.post('ajax.php', {
                    'id': id,
                    'amount': amount,
                    'action': 'buyItem'
                }, function(data) {
                    location.reload();
                });

            }

            var login = <?php echo $login ?>;
            function addToCart(id, amount) {

                if(login == 0) {
                    $("#modal").css("display", "flex");
                    $("body").css("overflow", "hidden");
                    return;
                }

                if(ajaxLoaded) return;
                ajaxLoaded = true;

                $.post('ajax.php', {
                    'id': id,
                    'amount': amount,
                    'status': 1,
                    'action': 'addToCart'
                }, function(data) {
                    location.reload();
                });

            }

            function userLogout() {

                if(ajaxLoaded) return;
                ajaxLoaded = true;

                $.post('ajax.php', {
                    'action': 'logout'
                }, function(data) {
                    location.reload();
                });
                
            }         

    </script>
</body>
</html>