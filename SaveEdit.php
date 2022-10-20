<?php
if(isset($_POST['result'])){
    $value = $_POST['result'];
    $con = "";
    include ('Library/Connect_DB.php');
    $sql = "UPDATE member SET FullName='".$value['fullname']."',IDCard ='".$value['idcard']."',Pass='".$value['pass']."',MailAddress='".$value['mail']."' WHERE IDMember='".$value['idmember']."'";
    $query = mysqli_query($con,$sql);
    $sql = "UPDATE managermember SET IDPosition='".$value['idposition']."' WHERE IDMember='".$value['idmember']."' AND IDDept='".$value['iddept']."'";
    $query = mysqli_query($con,$sql);
    echo json_encode(['result'=>"OK",'value'=>$value,'code'=>200]);
}
else echo json_encode(['code'=>201]);
?>
