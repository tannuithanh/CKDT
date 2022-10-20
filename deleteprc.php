<?php
session_start();
if(isset($_POST['result'])) {
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "DELETE FROM approvegrc WHERE Position1='" .$value['id1']. "' AND Position2='" .$value['id2']. "' AND Position3='" .$value['id3']. "'";
    $query = mysqli_query($con, $sql);

    echo json_encode(['result'=>@$sql,'code'=>200,'TEST'=>$sql]);
}
else
    echo json_encode(['code'=>201,'TEST'=>'NG']);
?>