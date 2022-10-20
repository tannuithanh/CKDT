<?php
session_start();
if(isset($_SESSION['idmember']))
{
    $idmember = $_SESSION['idmember'];
}
if(isset($_POST['result'])) {
    $v='';
    $con='';
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    if($value['value']=="1") {
        $sql = "UPDATE approve SET TimeStamp='".date('Y/m/d H:i:s')."',Approved=1,Deny=0,Note='".$value['note']."' WHERE IDFile='".$value['idfile']."' AND IDMember='".$idmember."'";
        $query = mysqli_query($con, $sql);
    }
    else
    {
        $sql = "UPDATE approve SET TimeStamp='".date('Y/m/d H:i:s')."',Approved=1,Deny=1,Note='".$value['note']."' WHERE IDFile='".$value['idfile']."' AND IDMember='".$idmember."'";
        $query = mysqli_query($con, $sql);
        $sql = "UPDATE managerfile SET Deny=1 WHERE IDFile='".$value['idfile']."'";
        $query = mysqli_query($con, $sql);
    }
    echo json_encode(['result'=>"OK",'code'=>200,'TEST'=>$sql,'valu'=>$value]);
}
else
    echo json_encode(['code'=>201]);
?>