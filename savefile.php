<?php
if(isset($_POST['result'])) {
    session_start();
    $idmember = $_SESSION['idmember'];
    $v='';
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $maphieu='';
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    /*echo date('Y-m-d\TH:i');*/
    $time = date('Ymd');
    $sql = "SELECT COUNT(*) as ct FROM managerfile WHERE date(Timestamp)='".date('Y-m-d')."' AND IDFuntion='".$value['idfunction']."'";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $maphieu = $value['idfunction'] . $time . sprintf('%03d', $row['ct'] + 1);
    }
    if($maphieu!='')
    {
        $sql="INSERT INTO managerfile(IDFile, IDMember, IDFuntion, Timestamp,IDMemberCreate) VALUES ('".$maphieu."','".$value['idmember']."','".$value['idfunction']."','".date('Y-m-d H:i:s')."','".$idmember."')";
        $query = mysqli_query($con, $sql);
        if($value['timein']=='')
        {
            $sql="INSERT INTO grc(IDFile, IDMember, TimeStampOut, Reason, LicensePlates, Bring, Note) VALUES ('".$maphieu."','".$idmember."','".$value['timeout']."','".$value['reason']."','".$value['licence']."','".$value['bring']."','".$value['note']."')";
            $query = mysqli_query($con, $sql);
        }
        else
        {
            $sql="INSERT INTO grc(IDFile, IDMember, TimeStampOut, TimeStampIn, Reason, LicensePlates, Bring, Note) VALUES ('".$maphieu."','".$idmember."','".$value['timeout']."','".$value['timein']."','".$value['reason']."','".$value['licence']."','".$value['bring']."','".$value['note']."')";
            $query = mysqli_query($con, $sql);
        }
        $sql = "INSERT INTO approve(IDFile, IDMember, Approved,No) VALUES ('".$maphieu."','".$value['idcheck']."',0,1),('".$maphieu."','".$value['idapprove']."',0,2)";
        $query = mysqli_query($con, $sql);
        echo json_encode(['result'=>$maphieu,'code'=>200,'query'=>$sql]);
    }
    else
    {
        echo json_encode(['result'=>"Thất bại rồi bạn ơi",'code'=>200,'query'=>$sql]);
    }
}
else
    echo json_encode(['code'=>201]);