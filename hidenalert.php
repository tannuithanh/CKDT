<?php
if(isset($_POST['result'])) {
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "UPDATE approve SET ShowNotify=1 WHERE IDFile='".$value['idfile']."' AND IDMember='".$value['idmember']."'";
    $query = mysqli_query($con, $sql);
    echo json_encode(['result'=>$value,'code'=>200,'query'=>$sql]);
}
else
    echo json_encode(['code'=>201]);