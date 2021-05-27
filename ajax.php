<?php
require_once ('db/dbhelper.php');

    if(!empty($_POST)) {
        
        $action = $_POST['action'];

        switch($action) {
            case 'logout':
                unset($_SESSION['USER_ID']);
                unset($_SESSION['CART']);
                break;
            case 'addToCart':
                if(isset($_POST['id']) && isset($_POST['amount']) && isset($_POST['status'])) {
                    if(isset($_SESSION['USER_ID'])) {

                        $MSHH = $_POST['id'];
                        $SoLuong = $_POST['amount'];
                       
                        if(!isset($_SESSION['CART'][''.$MSHH.'']))
                        {
                            $_SESSION['CART'][''.$MSHH.''] = array(
                                'MSHH' => $MSHH,
                                'SoLuong' => $SoLuong,
                            );

                        }
                        else {
                            $_SESSION['CART'][''.$MSHH.'']['SoLuong'] += $SoLuong;

                            $sql = 'SELECT * FROM HangHoa WHERE MSHH = "'.$_SESSION['CART'][''.$MSHH.'']['MSHH'].'"';
                            $result = executeSingle($sql);

                            $price = $_SESSION['CART'][''.$MSHH.'']['SoLuong'] * $result['Gia'];
                            
                            echo ''.number_format($price, 0, ',', '.').'₫';
                        }
                        if($_POST['status'] == 1) $_SESSION['CART_ADDED'] = true;
                    }
                }
                break;
            case 'removeFromCart':
                if(isset($_POST['id'])) {

                    if(isset($_SESSION['USER_ID'])) {

                        $MSHH = $_POST['id'];
                       
                        if(isset($_SESSION['CART'][''.$MSHH.'']))
                        {
                            if($_SESSION['CART'][''.$MSHH.'']['SoLuong'] > 1) {
                                $_SESSION['CART'][''.$MSHH.'']['SoLuong']--;

                                $sql = 'SELECT * FROM HangHoa WHERE MSHH = "'.$_SESSION['CART'][''.$MSHH.'']['MSHH'].'"';
                                $result = executeSingle($sql);

                                $price = $_SESSION['CART'][''.$MSHH.'']['SoLuong'] * $result['Gia'];
                                
                                echo ''.number_format($price, 0, ',', '.').'₫';
                            }
                            else {
                                unset($_SESSION['CART'][''.$MSHH.'']);
                            }
                        }
                    }

                }
                break;
            case 'deleteItemInCart':
                if(isset($_POST['id'])) {

                    if(isset($_SESSION['USER_ID'])) {

                        $MSHH = $_POST['id'];
                        
                        if(isset($_SESSION['CART'][''.$MSHH.'']))
                        {
                                unset($_SESSION['CART'][''.$MSHH.'']);
                        }
                    }

                }
                break;
            case 'buyItem':
                if(isset($_POST['id']) && isset($_POST['amount'])) {
                    $MSHH = $_POST['id'];
                    $SoLuong = $_POST['amount'];
                    buyItem($MSHH, $SoLuong);
                }
                break;
            case 'buyItemFromCart':
                if(isset($_SESSION["USER_ID"]) && isset($_SESSION['CART']) && !empty($_SESSION['CART']))
                {
                    foreach($_SESSION['CART'] as $item) {
                        $MSHH = $item['MSHH'];
                        $SoLuong = $item['SoLuong'];
                        buyItem($MSHH, $SoLuong);
                    }
                    unset($_SESSION['CART']);
                }
                break;
            case 'deleteLoaiGame':
                if(isset($_POST['id'])) {

                    $id = $_POST['id'];
                    $sql = 'DELETE FROM LoaiHangHoa WHERE MaLoaiHang = "'.$id.'"';

                    execute($sql);

                }
                break;
            case 'deleteGame':
                if(isset($_POST['id'])) {

                    $id = $_POST['id'];
                    $sql = 'DELETE FROM HangHoa WHERE MSHH = "'.$id.'"';

                    execute($sql);

                }
                break;
            case 'deleteCategory':
                if(isset($_POST['id'])) {

                    $id = $_POST['id'];
                    $sql = 'DELETE FROM category WHERE code_category = "'.$id.'"';

                    execute($sql);

                }
                break;
            case 'deleteMember':
                if(isset($_POST['id'])) {

                    $id = $_POST['id'];
                    $sql = 'DELETE FROM KhachHang WHERE MSKH = "'.$id.'"';

                    execute($sql);

                }
                break;
            case 'deleteStaff':
                if(isset($_POST['id'])) {

                    $id = $_POST['id'];
                    $sql = 'DELETE FROM NhanVien WHERE MSNV = "'.$id.'"';

                    execute($sql);

                }
                break;
            case 'confirmDH':
                if(isset($_POST['id'])) {

                    $id = $_POST['id'];
                    
                    $sql = 'SELECT ChiTietDatHang.MSHH, ChiTietDatHang.SoLuong FROM ChiTietDatHang WHERE ChiTietDatHang.SoDonDH = "'.$id.'"';
                    $result_DH = executeResult($sql);
                    foreach($result_DH as $item) {
                        $sql = 'SELECT HangHoa.SoLuongHang FROM HangHoa WHERE HangHoa.MSHH = "'.$item['MSHH'].'"';
                        $result_SL = executeSingle($sql);
                        $SoLuong = $result_SL['SoLuongHang'] - $item['SoLuong'];
                        if($SoLuong < 0) $SoLuong = 0;
                        $sql = 'UPDATE HangHoa SET HangHoa.SoLuongHang = '.$SoLuong.' WHERE HangHoa.MSHH = "'.$item['MSHH'].'"';
                        execute($sql);
                    }
                    $sql = 'DELETE FROM DatHang WHERE SoDonDH = "'.$id.'"';
                    execute($sql);
                }
                break;
        }
    }

    function buyItem($id, $amount) {
        if(isset($_SESSION['USER_ID'])) {
                    
            $MSHH = $id;
            $SoLuong = $amount;
            $username = $_SESSION['USER_ID'];

            $sql = 'SELECT * From HangHoa WHERE MSHH = "'.$MSHH.'"';
            $result_item = executeSingle($sql);
            $Gia = $GiaDatHang = $result_item['Gia'];
            $NgayDH = date('Y-m-d H:i:s');

            $sql = 'SELECT * From DatHang WHERE MSKH = "'.$username.'"';
            $result_user = executeSingle($sql);
            $SoDonDH = $result_user['SoDonDH'];
            if($result_user == null) 
            {
                    $SoDonDH = 1;
                    $sql = 'SELECT MAX(SoDonDH) as SoDonDH From DatHang';
                    $result_SoDonDH = executeSingle($sql);
                    if($result_SoDonDH != null) 
                    {
                        $SoDonDH = $result_SoDonDH['SoDonDH'];
                        $SoDonDH++;
                    }
                    
                    $sql = 'INSERT INTO DatHang(SoDonDH, MSKH, NgayDH) values("'.$SoDonDH.'", "'.$username.'", "'.$NgayDH.'")';
                    execute($sql);

                    $sql = 'INSERT INTO ChiTietDatHang(SoDonDH, MSHH, Gia, SoLuong, GiaDatHang) values("'.$SoDonDH.'", "'.$MSHH.'", "'.$Gia.'", "'.$SoLuong.'", "'.$GiaDatHang.'")';
                    execute($sql);
            }
            else {
                $sql = 'SELECT * From ChiTietDatHang WHERE SoDonDH = "'.$SoDonDH.'" AND MSHH = "'.$MSHH.'"';
                $result_item = executeSingle($sql);
                if($result_item != null) 
                {
                    $sql = 'SELECT SoLuong From ChiTietDatHang WHERE SoDonDH = "'.$SoDonDH.'" AND MSHH = "'.$MSHH.'"';
                    $result = executeSingle($sql);
                    $amount = $result['SoLuong'];
                    $amount += $SoLuong;

                    $sql = 'UPDATE DatHang SET NgayDH = "'.$NgayDH.'" WHERE SoDonDH = "'.$SoDonDH.'"';
                    execute($sql);

                    $sql = 'UPDATE ChiTietDatHang SET SoLuong = "'.$amount.'" WHERE SoDonDH = "'.$SoDonDH.'" AND MSHH = "'.$MSHH.'"';
                    execute($sql);
                }
                else {
                    $sql = 'UPDATE DatHang SET NgayDH = "'.$NgayDH.'" WHERE SoDonDH = "'.$SoDonDH.'"';
                    execute($sql);

                    $sql = 'INSERT INTO ChiTietDatHang(SoDonDH, MSHH, Gia, SoLuong, GiaDatHang) values("'.$SoDonDH.'", "'.$MSHH.'", "'.$Gia.'", "'.$SoLuong.'", "'.$GiaDatHang.'")';
                    execute($sql);
                }
            }
            $_SESSION['PURCHASED'] = true;

        }
    }