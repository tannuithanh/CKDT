<?php
if(isset($_POST['result'])) {
    $value = $_POST['result'];
    $v = array();
    $con = "";
    $id="";
    $end = $value*50;
    $start = $end-50;
    include ('Library/Connect_DB.php');
    $sql = "SELECT gxp.IDFile,member.FullName,dept.NameDept,gxp.Reason,DATE_FORMAT(gxp.TimeStampStart,'%H:%i:%s %d/%m/%Y') as TimeStampStart ,DATE_FORMAT(gxp.TimeStampEnd,'%H:%i:%s %d/%m/%Y') as TimeStampIn,gxp.Note FROM managerfile,gxp,approve,member,managermember,dept WHERE member.IDMember = managerfile.IDMember AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND managerfile.IDFile = gxp.IDFile AND gxp.IDFile = approve.IDFile AND approve.No=2 AND approve.Approved=1 AND approve.Deny=0 AND managerfile.IDMember like '%".$value."%' ORDER BY managerfile.Timestamp DESC";
    //$sql = "SELECT grc.IDFile,member.FullName,dept.NameDept,grc.Reason,DATE_FORMAT(grc.TimeStampOut,'%H:%i:%s %d/%m/%Y') as TimeStampOut ,DATE_FORMAT(grc.TimeStampIn,'%H:%i:%s %d/%m/%Y') as TimeStampIn,grc.LicensePlates,grc.Bring,grc.Note FROM managerfile,grc,approve,member,managermember,dept WHERE member.IDMember = managerfile.IDMember AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND managerfile.IDFile = grc.IDFile AND grc.IDFile = approve.IDFile AND approve.No=2 AND approve.Approved=1 AND approve.Deny=0 AND managerfile.IDFile like '%".$value."%'ORDER BY managerfile.Timestamp DESC";
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