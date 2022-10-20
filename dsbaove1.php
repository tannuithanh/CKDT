<?php
if(isset($_POST['result'])) {
    $value = $_POST['result'];
    $v = array();
    $con = "";
    $id="";
    $end = $value*50;
    $start = $end-50;
    include ('Library/Connect_DB.php');
    $sql = "SELECT gvc.IDFile,member.FullName,dept.NameDept,gvc.Reason,DATE_FORMAT(gvc.TimeStampOut,'%H:%i:%s %d/%m/%Y') as TimeStampOut ,DATE_FORMAT(gvc.TimeStampIn,'%H:%i:%s %d/%m/%Y') as TimeStampIn,gvc.LicensePlates,gvc.Bring,gvc.Note,gvc.NameIn,gvc.Donvi,DATE_FORMAT(gvc.AcceptOut,'%H:%i:%s %d/%m/%Y') as AcceptOut,DATE_FORMAT(gvc.AcceptIn,'%H:%i:%s %d/%m/%Y') as AcceptIn FROM managerfile,gvc,approve,member,managermember,dept WHERE member.IDMember = managerfile.IDMember AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND managerfile.IDFile = gvc.IDFile AND gvc.IDFile = approve.IDFile AND approve.No=2 AND approve.Approved=1 AND approve.Deny=0 ORDER BY managerfile.Timestamp DESC LIMIT ".$start.",100";
    //$sql = "SELECT gvc.IDFile,member.FullName,dept.NameDept,gvc.Reason,DATE_FORMAT(gvc.TimeStampOut,'%H:%i:%s %d/%m/%Y') as TimeStampOut ,DATE_FORMAT(gvc.TimeStampIn,'%H:%i:%s %d/%m/%Y') as TimeStampIn,gvc.LicensePlates,gvc.Bring,gvc.Note FROM managerfile,gvc,approve,member,managermember,dept WHERE member.IDMember = managerfile.IDMember AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND managerfile.IDFile = gvc.IDFile AND gvc.IDFile = approve.IDFile AND approve.No=2 AND approve.Approved=1 AND approve.Deny=0 AND managerfile.IDFile like '%".$value."%'ORDER BY managerfile.Timestamp DESC";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $v[]=$row;
        }
    }
    echo json_encode(['result'=>$v,'code'=>200,'Value'=>$sql]);
}
else
    echo json_encode(['code'=>201]);