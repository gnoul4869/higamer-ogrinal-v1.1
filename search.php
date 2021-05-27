<?php

    require_once('db/dbhelper.php');

    $cartItem = 0;
    if(isset($_SESSION["USER_ID"]) && isset($_SESSION['CART']) && !empty($_SESSION['CART']))
    {
        foreach($_SESSION['CART'] as $item) {
            $SoLuong = $item['SoLuong'];
            $cartItem += $SoLuong;
        }
    }

    $search = '';
    if(isset($_GET['id'])) {
        $search = $_GET['id'];
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
    <link rel="stylesheet" href="css/misc.css">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/icon.png" sizes="16x16 32x32" type="image/png">
    <title>Kết quả tìm kiếm: <?=$search?> - HiGamer</title>
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
            <li>KẾT QUẢ TÌM KIẾM: <?=$search?></li>
        </ul>
        
        <div id="main">
            
            <?php
        
                    echo ' 
                        <div class="section">
                            <div class="section-title">
                                    <h1>Kết quả tìm kiếm: <span style="color: #ffffa7">'.$search.'</span></h1> 
                            </div>
                        </div>
                        <div class="game-list">';

                            $sql = 'SELECT HangHoa.MSHH, HangHoa.Gia, HangHoa.thumbnail FROM HangHoa WHERE HangHoa.TenHH LIKE "%'.$search.'%" ORDER BY HangHoa.TenHH';
                            $result = executeResult($sql);
                            if($result != null) {
                                foreach($result as $item) {       
                                    echo '
                                    <a href="item.php?id='.$item["MSHH"].'">
                                    
                                       <div class="game-tag">
           
                                           <img src="'.$item['thumbnail'].'" style="width: 200px; height: 240px;">
                                           <div class="price-tag">
                                               <img src="images/price_tag.jpg" style="width: 200px; height: 50px;">
                                               <h2>'.number_format($item['Gia'], 0, ',', '.').'₫</h2>   
                                           </div>  
                                                       
                                       </div>
           
                                   </a>';
                                }
                            }
                            else echo '<h1 style="margin-top: 80px;">Không có kết quả nào được tìm thấy :(</h1>';

                        echo '</div>';

            ?>
    
        </div>

        <div id="footer">
            <div id="copyright">&copy; HiGamer - Designed by gnoul_</div>
        </div>

    </div>
    <!-- JavaScript -->
    <script src="js/main.js"></script>
    <script>

            $('body').append('<style>#main .section .section-title h1:before, .section-title h1:after{content: none;}</style>');

            ajaxLoaded = false;

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