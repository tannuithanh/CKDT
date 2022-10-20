<?php
if(isset($_POST['result'])) {
    $v='';
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvegrc WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvegrc.Position3 FROM position,approvegrc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvegrc.Position1 AND member.IDMember='".$value."') ORDER BY position.IDPosition ASC";
    $query = mysqli_query($con, $sql);
    if($query->num_rows>0){
        while($row=$query->fetch_all(MYSQLI_ASSOC)){
            $v = $row;
            echo json_encode(['result'=>$v,'code'=>200,'query'=>$sql]);
        }
    }
    else
        echo json_encode(['code'=>201,'query'=>$sql]);
}