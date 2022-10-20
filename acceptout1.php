<?php
if(isset($_POST['result'])) {
    $v='OK';
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time="";
    $time = date('Y-m-d\TH:i');
    $sql = "UPDATE gvc set AcceptOut='".$time."' where IDFile='".$value."'";
    $query = mysqli_query($con, $sql);
    echo json_encode(['result'=>$v,'code'=>200,'query'=>$sql]);
}
else
        echo json_encode(['code'=>201,'query'=>$sql]);
?>