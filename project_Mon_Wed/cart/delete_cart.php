<?php
    include_once '../database/dbhelper.php';
    include_once '../utils/ulitity.php';
    if(isset($_GET['delete_cart'])) {
        session_start();
        $email = $_SESSION['TenDN'];
        $sql = "SELECT * FROM tblkhachhang WHERE TenDN ='$email' OR EmailKH='$email'";
        $data = executeResult($sql,true);
        $user_Ma = $data['MaKH'];
        $product_Ma = $_GET['delete_cart'];
        $sql = "DELETE FROM tblgiohang WHERE MaSP='$product_Ma' AND MaKH= '$user_Ma'";
        execute($sql);
        header('Location: ./');
    }
?>