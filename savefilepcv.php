<?php
if(isset($_POST['result'])) {
    session_start();
    $iddept = $_SESSION['IDDept'];
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
    function Insert1($maphieu,$value){
        $sql = "INSERT INTO approve(IDFile, IDMember, Approved,No) VALUES ('".$maphieu."','".$value['idcheck1']."',0,1),('".$maphieu."','".$value['idcheck2']."',0,2),('".$maphieu."','".$value['idkiemtra']."',0,3),('".$maphieu."','".$value['idapprove']."',0,4)";
        return $sql;
    }
    function Insert($maphieu,$value){
        $sql = "INSERT INTO approve(IDFile, IDMember, Approved,No) VALUES ('".$maphieu."','".$value['idcheck1']."',0,1),('".$maphieu."','".$value['idcheck2']."',0,2),('".$maphieu."','".$value['idapprove']."',0,3)";
        return $sql;
    }

    function Run($con,$sql){
        $query = mysqli_query($con,$sql);
        return $query;
    }
    if($maphieu!='')
    {
        $sql="INSERT INTO managerfile(IDFile, IDMember, IDFuntion, Timestamp,IDMemberCreate) VALUES ('".$maphieu."','".$value['idmember']."','".$value['idfunction']."','".date('Y-m-d H:i:s')."','".$idmember."')";
        $query = mysqli_query($con, $sql);
        $sql="INSERT INTO pcv(IDFile, IDDept, Content, TimeStamp, Note, ngaytao) VALUES ('".$maphieu."','".$value['deptneed']."','".$value['content']."','".$value['timesend']."','".$value['note']."','".$value['ngaytao']."')";
        $query = mysqli_query($con, $sql);
        if($iddept == 'D0010' || $iddept == 'D0002' ||$iddept == 'D0015' ){
            Run($con,Insert1($maphieu,$value));
        }else{
            Run($con,Insert($maphieu,$value));
        }

        echo json_encode(['result'=>$maphieu,'code'=>200,'query'=>$sql]);
    }
    else
    {
        echo json_encode(['result'=>"Thất bại rồi bạn ơi",'code'=>200,'query'=>$sql]);
    }
}
else
    echo json_encode(['code'=>201]);

