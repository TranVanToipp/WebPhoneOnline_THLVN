<?php
ob_start();
session_start();
$msg = '';
function randomMa($length = 7)
{
	$s='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$sLength= strlen($s);
	$randomMXN='';
	for($i=0;$i<$length;$i++){
		$randomMXN.=$s[rand(0,$sLength-1)];
	}
	return $randomMXN;
}
function layMaKH(){
	$sql="SELECT * FROM tblkhachhang";
	$Ma_user=executeResult($sql);
	$makH="";
	while($makH==""){
		$makH="KH_".randomMa();
		foreach($Ma_user as $row){
		if($row['MaKH']==$makH)
			$makH="";
		}
	}
	return $makH;
}
function layTenDN($DN){
	$sql="SELECT * FROM tbltaikhoan where TenDN='$DN'";
	$DN_user=executeResult($sql,true);
	return $DN_user;
}
function layEmail($e){
	$sql="SELECT * FROM tbltaikhoan where Email ='$e'";
	$DN_user=executeResult($sql,true);
	return $DN_user;
}
// function maxacnhan($length = 7)//hàm random.
// {
// 	$s='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
// 	$sLength= strlen($s);
// 	$randomMXN='';
// 	for($i=0;$i<$length;$i++){
// 		$randomMXN.=$s[rand(0,$sLength-1)];
// 	}
// 	return $randomMXN;
// }
if(!empty($_POST)){
$fullName=getPost('fullname');
$Email=getPost('email');
$tenDN=getPost('TenDN');
$pws=getPost('MatKhau');
$rpws=getPost('confirmation_pwd');
$ltk="Khách Hàng";
$maKH=layMaKH();
if(layTenDN($tenDN)== null){
	if(layEmail($Email)==null){
		if($pws==$rpws){
			$date=''; $gender=''; $address=''; $sdt='';	
			$sql="INSERT INTO tbltaikhoan(TenDN, MatKhau, Email, LoaiTaiKhoan) VALUES ('$tenDN',md5('$pws'),'$Email','$ltk')";
			$sql1="INSERT INTO tblkhachhang(MaKH, TenDN, TenKH, NgaySinh, GioiTinh, DiaChiKH, SDT, EmailKH) 
				VALUES ('$maKH','$tenDN','$fullName','$date','$gender','$address','$sdt','$Email')";
			// $sql2="DELETE FROM tblmaxacnhan WHERE TenDN='$tendn'";
			$TK_User=execute($sql);
			$TT_User=execute($sql1);
			// $Del_User=execute($sql2);
			header('Location: ../login');
		}
		else
			$msg = 'Mật Khẩu Không Khớp, vui lòng kiểm tra lại thông tin';
	}
	else
		$msg = 'Email này đã được đăng ký, vui lòng kiểm tra lại thông tin';
}
else
	$msg = 'Tên Đăng Nhập Đã Tồn Tại, vui lòng kiểm tra lại thông tin';
}
?>