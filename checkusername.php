<?php
if(isset($_POST['result'])){
    $value = $_POST['result'];
    $con = "";
    $result="";
    include ('Library/Connect_DB.php');
    $sql = "SELECT member.IDMember, member.FullName,dept.IDDept,dept.NameDept,position.IDPosition,position.NamePosition,position.IDGroup FROM member,dept,position,managermember WHERE managermember.IDMember = member.IDMember AND managermember.IDPosition = position.IDPosition AND  managermember.IDDept = dept.IDDept AND member.IDMember='".$value['username']."' AND member.Pass='".$value['password']."'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $result = $row;
        }
    }
    echo json_encode(['result'=>$result,'code'=>200]);
}
else echo json_encode(['code'=>201]);
?>
