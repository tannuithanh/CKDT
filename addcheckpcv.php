<?php
if(isset($_POST['result'])) {
    $v='';
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "SELECT member.IDMember,member.FullName FROM managermember,position,member WHERE managermember.IDMember = member.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup <>'G0003' AND position.IDGroup <>'G0005' AND position.IDGroup <>'G0011'  AND managermember.IDDept='".$value."'";
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
?>