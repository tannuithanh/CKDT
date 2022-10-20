<?php
session_start();
$iddept = $_SESSION['IDDept'];
if(isset($_POST['result'])) {
    $v='';
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "SELECT member.IDMember,member.FullName,member.IDCard,member.MailAddress,dept.NameDept,dept.IDDept,position.NamePosition,position.IDPosition,member.Pass,member.AdminUser FROM member,dept,position,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND member.IDMember='".$value."' AND dept.IDDept='".$iddept."'";
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