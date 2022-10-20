<?php
if(isset($_POST['result'])){
    $value = $_POST['result'];
    $con = "";
    include ('Library/Connect_DB.php');
    $sql = "DELETE FROM member WHERE IDMember='".$value['idmember']."'";
    $query = mysqli_query($con,$sql);
    $sql ="DELETE FROM `managermember` WHERE IDMember='".$value['idmember']."'";
    $query = mysqli_query($con,$sql);
    echo json_encode(['result'=>"OK",'code'=>200]);
}
else echo json_encode(['code'=>201]);
?>
