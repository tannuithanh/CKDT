<?php
// echo '<pre>';
// var_dump($_POST);
// exit;
include ('Library/Connect_DB.php');
if(isset($_POST['manv'])){
    $manv = $_POST['manv'];
    $hovaten = $_POST['hovaten'];
    $phongban = $_POST['phongban'];
    $chucvu = $_POST['chucvu'];
    $bophantiepnhan = $_POST['bophantiepnhan'];
    $thongtinsanpham = $_POST['thongtinsanpham'];
    $mucdichthunghien = $_POST['mucdichthunghien'];
    $nguoitacnghiep = $_POST['nguoitacnghiep'];
    $sodienthoai = $_POST['sodienthoai'];
    $ghichu = $_POST['ghichu'];
    $ngayhoanthanh = $_POST['ngayhoanthanh'];
    $ngaytaophieu = $_POST['ngaytaophieu'];
}
$sql = "INSERT INTO phieuthunghiem (manv, hovaten, phongban, chucvu, bophantiepnhan, thongtinsanpham, mucdichthunghien, nguoitacnghiep, sodienthoai, ghichu, ngayhoanthanh, ngaytaophieu)
VALUES ('$manv','$hovaten','$phongban','$chucvu','$bophantiepnhan','$thongtinsanpham','$mucdichthunghien','$nguoitacnghiep','$sodienthoai','$ghichu','$ngayhoanthanh','$ngaytaophieu');";
$result = mysqli_query($con,$sql);
header('location:phieuthunghiem1.php');
?>