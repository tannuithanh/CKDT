<?php
if(isset($_POST['result'])) {
    $con = "";
    include('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "UPDATE settingline SET IDEating='".$value['td2']."' WHERE IDLine='".$value['td1']."' AND IDTime='".$value['time']."'";
    $query = mysqli_query($con, $sql);
    echo  json_encode(['result'=>"OK",'code'=>200]);
}
else echo json_encode(['code'=>201]);