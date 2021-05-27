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
    <meta name="keywords" content="HiGamer, higamer.cf">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/90336495ef.js" crossorigin="anonymous"></script>
    <!-- Open Sans Font -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans"/>
    <!-- CSS -->
    <link rel="stylesheet" href="css/main.css">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/icon.png" sizes="16x16 32x32" type="image/png">
    <title>HiGamer - Website Chuyên Cung Cấp Game Bản Quyền Chính Hãng</title>
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
                                        <a href="" title="Đăng xuất" onclick="userLogout(); return false;">Đăng xuất <span style="margin-left: 6px;"><i class="fas fa-sign-out-alt"></i></span></a>
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
        
        <div id="banner">

            <div class="mySlides fade">
                <div class="banner-number">1 / 5</div>
                <img src="images/Banners/yakuza7.jpg" style="width:1080px; height:360px">
                <div class="banner-text">Yakuza 7: Like A Dragon</div>
            </div>  

            <div class="mySlides fade">
                <div class="banner-number">2 / 5</div>
                <img src="images/Banners/ffxv.jpg" style="width:1080px; height:360px">
                <div class="banner-text">FINAL FANTASY XV WINDOWS EDITION</div>
            </div> 

            <div class="mySlides fade">
                <div class="banner-number">3 / 5</div>
                <img src="images/Banners/nierautomata.jpg" style="width:1080px; height:360px">
                <div class="banner-text">NieR:Automata™ Game of the YoRHa Edition</div>
            </div>

            <div class="mySlides fade">
                <div class="banner-number">4 / 5</div>
                <img src="images/Banners/sekiro.jpg" style="width:1080px; height:360px;">
                <div class="banner-text">Sekiro™: Shadows Die Twice - GOTY Edition</div>
            </div>

            <div class="mySlides fade">
                <div class="banner-number">5 / 5</div>
                <img src="images/Banners/tw3.jpg" style="width:1080px; height:360px">
                <div class="banner-text">The Witcher® 3: Wild Hunt</div>
            </div>

            <div id="banner_btn">
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>           
            </div>

            <div id="banner_control">
                <span class="banner-dot" onclick="currentSlide(1)"></span>
                <span class="banner-dot" onclick="currentSlide(2)"></span>  
                <span class="banner-dot" onclick="currentSlide(3)"></span>
                <span class="banner-dot" onclick="currentSlide(4)"></span>
                <span class="banner-dot" onclick="currentSlide(5)"></span>
            </div>

        </div>
        
        <div id="main">
            
            <?php

                $sql = 'SELECT * FROM category WHERE category.name_category NOT IN (SELECT category.name_category FROM category WHERE category.name_category = "DEFAULT")';
                $category = executeResult($sql);

                foreach($category as $item) {       
                    echo '
                    <div class="section">
                        <div class="section-title">
                                <h1>'.$item["name_category"].'</h1>     
                        </div>
                    </div>
                    <div class="game-list">';

                    $sql = '(SELECT DISTINCT HangHoa.MSHH, HangHoa.Gia, HangHoa.thumbnail FROM HangHoa INNER JOIN category ON HangHoa.code_category = "'.$item["code_category"].'" 
                            ORDER BY HangHoa.updated_at DESC LIMIT 5)';
                    $game = executeResult($sql);

                    foreach($game as $item) {
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

                    echo '</div>';
                }

            ?>

            <span id="see_all">
                <a href="games.php">
                    <h2>Xem Tất Cả</h2>
                    <i class="fas fa-caret-down"></i>
                </a>
            </span>
    
        </div>

        <div id="footer">
            <div id="copyright">&copy; HiGamer - Designed by gnoul_</div>
        </div>

    </div>
    <!-- JavaScript -->
    <script src="js/main.js"></script>
    <script>

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
                
            //------------------------------------------------------------------------------------------------//

            var slideIndex = 1;
            var slideInterval;
            var slides = document.getElementsByClassName("mySlides");

            // Next or Previous Slide
            function plusSlides(n) {
                showSlides(slideIndex += n);
            }

            // Current Slide
            function currentSlide(n) {
                showSlides(slideIndex = n);
            }

            // Show Slide
            function showSlides(n) {
                var i;
                var dots = document.getElementsByClassName("banner-dot");
                if (n > slides.length) {slideIndex = 1}
                if (n < 1) {slideIndex = slides.length}
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex-1].style.display = "block";
                dots[slideIndex-1].className += " active";

                // Stop And Start autoShowSlides Timer
                clearInterval(slideInterval);
                slideInterval = setInterval(autoShowSlide, 5000);
            }
            
            // Auto Show Slides
            function autoShowSlide() {
                if(slideIndex <= slides.length) 
                    slideIndex++;
                else slideIndex = 1;
                showSlides(slideIndex);
            }

            $(document).ready(function() {
                showSlides(slideIndex);
            });

            //------------------------------------------------------------------------------------------------//

    </script>
</body>
</html>