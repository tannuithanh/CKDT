<?php
session_start();
if(isset($_SESSION['idmember']))
{
    $idmember = $_SESSION['idmember'];
}
function CheckAdminUser()
{
    $con = "";
    $v ='';
    include ('Library/Connect_DB.php');
    $sql = "SELECT AdminUser FROM member WHERE IDMember='".$_SESSION['idmember']."'";
    $query=mysqli_query($con,$sql);
    while ($row=$query->fetch_assoc())
    {
        $v=$row['AdminUser'];
    }
    return $v;
}
if(isset($_GET['ID']))
{
    if(CheckAdminUser())
    {
        $con = "";
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $v = date('Y-m-d H:m:s');
        include ('Library/Connect_DB.php');
        $date = strtotime('+10 day',strtotime($v));
        $date = date('Y-m-d H:m:s',$date);
        $sql = "UPDATE detailrequest SET TimeOut='".$date."' WHERE IDRequest='".$_GET['ID']."'";
        $query=mysqli_query($con,$sql);
        echo '<script> alert("'.$sql.'")</script>';
        header("Location: "."../RD/CreateNew.php");
    }
}
?>