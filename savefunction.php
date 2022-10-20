<?php
session_start();
if(isset($_POST['value'])) {
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['value'];
    foreach($value as $v)
    {
        $sql = "SELECT FunctionParent,FunctionChild FROM parentchild WHERE FunctionParent='" .$v['idfuntion']. "'";
        $query = mysqli_query($con, $sql);

        echo json_encode(['result'=>$query,'code'=>200,'TEST'=>$sql,'valu'=>$con]);
    }
}
else
    echo json_encode(['code'=>201,'TEST'=>'NG']);
?>