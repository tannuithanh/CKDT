<?php
if(isset($_POST['result'])) {
    $value = $_POST['result'];
    $v = array();
    $con = "";
    $id="";
    $end = $value*50;
    $start = $end-50;
    include ('Library/Connect_DB.php');
    $sql = "SELECT DISTINCT (ptc.IDFile),dept.NameDept,DATE_FORMAT(managerfile.Timestamp,'%H:%i:%s %d/%m/%Y') as Timestamp FROM managerfile,ptc,approve,member,managermember,dept WHERE member.IDMember = managerfile.IDMember AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND managerfile.IDFile = ptc.IDFile AND ptc.IDFile = approve.IDFile AND approve.No=2 AND approve.Approved=1 AND approve.Deny=0 ORDER BY managerfile.Timestamp DESC LIMIT ".$start.",500"; 
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