<?php
session_start();
$v=array();
$con = "";
include ('Library/Connect_DB.php');
$value = $_POST['result'];
$sql = "SELECT COUNT(*) as ct FROM member";
$query = mysqli_query($con, $sql);
$row=mysqli_fetch_array($query);
$allmember = $row['ct'];
$sql2 = "SELECT COUNT(*) AS ct FROM registeating,member WHERE registeating.IDMember = member.IDMember and registeating.IDTime=1 AND registeating.Work=1 AND DAY(registeating.TimeStamp)='".date('d')."' AND MONTH(registeating.TimeStamp)='".date('m')."' AND YEAR(registeating.TimeStamp)='".date('Y')."'";
$query = mysqli_query($con, $sql2);
$row=mysqli_fetch_array($query);
$workmember = $row['ct'];
$sql2 = "SELECT COUNT(*) AS ct FROM registeating,member WHERE registeating.IDMember = member.IDMember and registeating.IDTime=2 AND registeating.Work=1 AND DAY(TimeStamp)='".date('d')."' AND MONTH(registeating.TimeStamp)='".date('m')."' AND YEAR(registeating.TimeStamp)='".date('Y')."'";
$query = mysqli_query($con, $sql2);
$row=mysqli_fetch_array($query);
$workmember2 = $row['ct'];
$sql2 = "SELECT COUNT(*) AS ct FROM registeating,member WHERE registeating.IDMember = member.IDMember and registeating.IDTime=1 AND registeating.Work=0 AND DAY(TimeStamp)='".date('d')."' AND MONTH(registeating.TimeStamp)='".date('m')."' AND YEAR(registeating.TimeStamp)='".date('Y')."'";
$query = mysqli_query($con, $sql2);
$row=mysqli_fetch_array($query);
$memberout = $row['ct'];
$v = array($allmember,$workmember,$workmember2,$memberout);
echo json_encode(['result'=>$v,'code'=>200]);