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
        $sqla="INSERT INTO managerfile(IDFile, IDMember, IDFuntion, Timestamp,IDMemberCreate) VALUES ('".$maphieu."','".$value['idmember']."','".$value['idfunction']."','".date('Y-m-d H:i:s')."','".$idmember."')";
        $query = mysqli_query($con, $sqla);

        foreach ($value['value'] as $item)
        {
            $sql="INSERT INTO ptc(IDFile,IDMember, PIC, 18h30, 20h45, 22h15, 24h00,ChuNhat, IDLocation, IDEationg, Note, ngaytao) VALUES ('".$maphieu."','".$item[0]."','".$item[1]."','".$item[2]."','".$item[3]."','".$item[4]."','".$item[5]."','".$item[6]."','".$item[7]."','".$item[8]."','".$item[9]."','".$value['ngaytao']."')";
            $query = mysqli_query($con, $sql);
        }
        $sql="UPDATE ptc SET NSQL=1,PhoneNumber='".$value['nsql'][1]."' WHERE IDFile='".$maphieu."' AND IDMember='".$value['nsql'][0]."'";
        $query = mysqli_query($con, $sql);
        $sql = "INSERT INTO approve(IDFile, IDMember, Approved,No) VALUES ('".$maphieu."','".$value['idcheck1']."',0,1),('".$maphieu."','".$value['idcheck2']."',0,2),('".$maphieu."','".$value['idapprove']."',0,3)";
        $query = mysqli_query($con, $sql);
        echo json_encode(['result'=>$maphieu,'code'=>200,'query'=>$sqla]);
    }
    else
    {
        echo json_encode(['result'=>"Thất bại rồi bạn ơi",'code'=>200,'query'=>$sql]);
    }
}
else
    echo json_encode(['code'=>201]);