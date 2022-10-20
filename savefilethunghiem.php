<?php
if(isset($_POST['result'])) {
    session_start();
    $idmember = $_SESSION['idmember'];
    $idfunction = $_POST['defaut_result']['idfunction'];
    $v='';
    $con = "";
    include ('Library/Connect_DB.php');
    $value =[];
    $value = $_POST['result'];
    $defaut_result = $_POST['defaut_result'];
    $maphieu='';
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    /*echo date('Y-m-d\TH:i');*/
    $time = date('Ymd');
    $sql = "SELECT COUNT(*) as ct FROM managerfile WHERE date(Timestamp)='".date('Y-m-d')."' AND IDFuntion='".$idfunction."'";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $maphieu = $idfunction . $time . sprintf('%03d', $row['ct'] + 1);
    }
    if($maphieu!='')
    { 
        //lu data vo bang managerfile
        $sql="INSERT INTO managerfile(IDFile, IDMember, IDFuntion, Timestamp,IDMemberCreate) VALUES ('".$maphieu."','".$defaut_result['idmember']."','".$defaut_result['idfunction']."','".date('Y-m-d H:i:s')."','".$idmember."')";
        $query = mysqli_query($con, $sql);

        foreach($value as $data) {
            //lu data vo bang phieu thu nghiem
            $sql="INSERT INTO phieuthunghiem(IDFile, IDDept,ThongtinSP,Mucdichthunghiem, TimeStamp,ngaytao,Nguoitacnghiep,Sdt,Note,Content, Tieuchidanhgia, Tieuchuanapdung, Ghichu1) 
            VALUES ('".$maphieu."','".$data['deptneed']."','".$data['ThongtinSP']."','".$data['Mucdichthunghiem']."','".$data['timesend']."','".$data['ngaytao']."','".$data['Nguoitacnghiep']."','".$data['Sdt']."','".$data['note']."','".$data['Content']."','".$data['Tieuchidanhgia']."','".$data['Tieuchuanapdung']."','".$data['Ghichu1']."')";
            $query = mysqli_query($con, $sql);
        }

        // luu data vao bang approve
        $sql = "INSERT INTO approve(IDFile, IDMember, Approved,No) VALUES ('".$maphieu."','".$defaut_result['idcheck1']."',0,1),('".$maphieu."','".$defaut_result['idkiemtra']."',0,2),('".$maphieu."','".$defaut_result['idcheck2']."',0,3),('".$maphieu."','".$defaut_result['idapprove']."',0,4)";
        $query = mysqli_query($con, $sql);

        echo json_encode(['result'=>$maphieu,'code'=>200,'query'=>$sql,'tan'=>$idmember,'data'=> true]);
        
        //Chú ý
       // foreach ($value['value'] as $item)
      //  {
       //     $sql="INSERT INTO phieuthunghiem(IDFile,Content, Tieuchidanhgia, Tieuchuanapdung, Ghichu1) VALUES ('".$maphieu."','".$item[0]."','".$item[1]."','".$item[2]."','".$item[3]."','".$item[4]."','".$item[5]."')";
       //     $query = mysqli_query($con, $sql);
       // }
    }
    else
    {
        echo json_encode(['result'=>"Thất bại rồi bạn ơi",'code'=>200,'query'=>$sql]);
    }
}
else
    echo json_encode(['code'=>201]);