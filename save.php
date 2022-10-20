<?php
session_start();
if(isset($_SESSION['idmember']))
{
    $idmember = $_SESSION['idmember'];
}
function CheckIDRequest()
{
    $con='';
    $idrequest ='';
    include ('Library/Connect_DB.php');
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $daynow = date('CNTTYmd');
    $sql="SELECT COUNT(*) as ct from member where IDRequest like '".$daynow."%'%)";
    $query=mysqli_query($con,$sql);
    while ($row=$query->fetch_assoc())
    {
        $idrequest = $daynow.sprintf('%03d',$row['ct']+1);
    }
    return $idrequest;
}
if(isset($_POST['result'])) {
    $v='';
    $con='';
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql="INSERT INTO detailrequest(IDRequest, IDMember, Content, Locationfile, TimeStamp, Note) VALUES ('".CheckIDRequest()."','".$idmember."','".$value['noidung']."','".$value['file.']."','".$value['ngaygui']."','".$value['note']."')";
    $query=mysqli_query($con,$sql);
    echo json_encode(['result'=>CheckIDRequest(),'code'=>200,'TEST'=>$sql,'valu'=>$value]);
    }
    else
        echo json_encode(['code'=>201]);
?>