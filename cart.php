<?php

    require_once('db/dbhelper.php');

    $username = $name = $email = $address = $phone = 'N/A';
    $price = 0;

    if(isset($_GET['id'])) {

        $username = $_GET['id'];
        $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$username.'"';
        $result = executeSingle($sql);
        if($result != null) {
            $name = $result['HoTenKH'];
            $email = $result['Email'];
            $address = $result['DiaChi'];
            $phone = $result['SoDienThoai'];
        }

    }

    $result = null;
    if(isset($_SESSION["USER_ID"])) {
        $sql = 'SELECT * FROM KhachHang WHERE MSKH = "'.$_SESSION["USER_ID"].'"';
        $result = executeSingle($sql);
    }
    if($result == null) {
        header('location: ./');
        die();
    }

    $cartItem = 0;
    $totalPrice = 0;
    if(isset($_SESSION["USER_ID"]) && isset($_SESSION['CART']) && !empty($_SESSION['CART']))
    {
        foreach($_SESSION['CART'] as $item) {
            $MSHH = $item['MSHH'];
            $SoLuong = $item['SoLuong'];

            $sql = 'SELECT * From HangHoa WHERE MSHH = "'.$MSHH.'"';
            $result = executeSingle($sql);

            $TenHH = $result['TenHH'];
            $Gia = $result['Gia'];
            $cartItem += $SoLuong;
            $totalPrice += $Gia * $SoLuong;
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
    <link rel="stylesheet" href="css/cart.css">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/icon.png" sizes="16x16 32x32" type="image/png">
    <title>Giỏ Hàng - HiGamer</title>
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
            <li>GIỎ HÀNG</li>
        </ul>
        
        <div id="main">

            <div class="section">
                <div class="section-title">
                        <h1>Giỏ hàng</h1> 
                </div>
            </div>

            <div id="panel"> 
            <?php
                        
                if(isset($_SESSION['CART']) && !empty($_SESSION['CART']))
                {
                    echo '
                    <div style="overflow-x:auto;">
                        <table class="info-table">

                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th colspan="2">SẢN PHẨM</th>                             
                                    <th>ĐƠN GIÁ</th>
                                    <th>SỐ LƯỢNG</th>
                                    <th>SỐ TIỀN</th>
                                    <th>THAO TÁC</th>
                                </tr>
                            </thead>
                            <tbody>';
                        
                                $index = 1;
                                foreach($_SESSION['CART'] as $item) {
                                    $MSHH = $item['MSHH'];
                                    $SoLuong = $item['SoLuong'];
                                    $sql = 'SELECT * From HangHoa WHERE MSHH = "'.$MSHH.'"';
                                    $result = executeSingle($sql);
                                    $TenHH = $result['TenHH'];
                                    $Gia = $result['Gia'];
                                    $Thumbnail = $result['thumbnail'];
                                    echo '
                                    <tr>
                                        <td>'.($index++).'</td>
                                        <td id="gameID" data-gameid="'.$MSHH.'"><a href="item.php?id='.$MSHH.'">'.$TenHH.'</a></td>
                                        <td><a href="item.php?id='.$MSHH.'"><img src="'.$Thumbnail.'" style="max-width: 90px;"></a></td>
                                        <td>'.number_format($Gia, 0, ',', '.').'₫</td>                                    
                                        <td style="width: 200px;">
                                            <div class="number">
                                                <div class="minus">-</div>
                                                    <input type="text" id="amount" value="'.$SoLuong.'"/>
                                                <div class="plus">+</div>
                                            </div>
                                        </td>
                                        <td id="amountPrice">'.number_format(($Gia * $SoLuong), 0, ',', '.').'₫</td>
                                        <td>
                                            <button class="button-del" onclick="deleteItemInCart(\''.$MSHH.'\')">Xoá</button>
                                        </td>
                                    </tr>';
                                }           
                                echo '
                            
                            </tbody>

                        </table>
                    </div>
                    <div id="Total">Tổng Thanh Toán ('.$cartItem.' Sản Phẩm): <span style="color: #ffffa7">'.number_format($totalPrice, 0, ',', '.').'₫</span></div>
                    <button class="button-main" style="margin-top: 40px" onclick="confirmItem()">Mua Hàng</button>';
                }
                else echo '<h1 style="margin-top: 80px;">Giỏ hàng của bạn còn trống :(</h1>'
            ?>

            </div>
    
        </div>

        <div id="footer">
            <div id="copyright">&copy; HiGamer - Designed by gnoul_</div>
        </div>

        <div id="modal">
            <div id="modal_content">
                <?php
                        if(isset($_SESSION['PURCHASED']) && $_SESSION['PURCHASED'] == true) {
                            echo '
                                <h3 style="color: #ffffa7">Cảm ơn bạn đã mua hàng tại HiGamer :D</h3>
                                <p style="margin-bottom: 30px;">Bạn vui lòng chờ nhân viên liên hệ để xác nhận thanh toán trong vòng 24H!</p>
                                <a href=""><button id="button_ok">OK</button></a>';
                        }
                        else {
                            if(isset($_SESSION['USER_ID'])) {
                                echo '
                                    <h3>Xác nhận mua hàng?</h3>
                                    <p>Tổng Thanh Toán ('.$cartItem.' Sản Phẩm): <span style="color: #ffffa7">'.number_format($totalPrice, 0, ',', '.').'₫</span></p>
                                    <div id="modal_button">
                                        <button id="button_ok" onclick="buyItemFromCart()">Mua Hàng</button>
                                        <button id="button_cancel" onclick="cancelItem()">Huỷ</button>
                                    </div>';
                            }
                            else echo '
                                    <h3>Hãy đăng nhập tài khoản trước khi mua hàng!</h3>
                                    <a href="login.php"><button id="button_login">Đăng nhập</button></a>';
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
    ?>
    <!-- JavaScript -->
    <script src="js/main.js"></script>
    <script>

            ajaxLoaded = false;

            function confirmItem() {
                $("#modal").css("display", "flex");
            }

            function cancelItem() {
                $("#modal").css("display", "none");
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

            function buyItemFromCart() {

                if(ajaxLoaded) return;
                ajaxLoaded = true;

                $.post('ajax.php', {
                    'action': 'buyItemFromCart'
                }, function(data) {
                    location.reload();
                });

            }

            function deleteItemInCart(id) {

                if(ajaxLoaded) return;
                ajaxLoaded = true;

                $.post('ajax.php', {
                    'id': id,
                    'action': 'deleteItemInCart'
                }, function(data) {
                    location.reload();
                });
            }

            $('.minus').click(function () {

                if(ajaxLoaded) return;
                ajaxLoaded = true;

				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				if(count > 0)
                {
				    $input.val(count);
                    id = $(this).parents('td').siblings('#gameID').data('gameid');
                    // $this = $(this).parents('td').siblings('#amountPrice');
                    $.post('ajax.php', {
                        'id': id,
                        'action': 'removeFromCart'
                    }, function(data, status) {
                        // $this.html(data);
                        location.reload();
                    });
                }
				return false;
			});

			$('.plus').click(function () {

                if(ajaxLoaded) return;
                ajaxLoaded = true;

				var $input = $(this).parent().find('input');
				$input.val(parseInt($input.val()) + 1);

                id = $(this).parents('td').siblings('#gameID').data('gameid');
                // $this = $(this).parents('td').siblings('#amountPrice');
                $.post('ajax.php', {
                    'id': id,
                    'amount': 1,
                    'status': 0,
                    'action': 'addToCart'
                }, function(data) {
                    // $this.html(data);
                    location.reload();
                });
				return false;
			});

    </script>
</body>
</html>