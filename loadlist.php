<?php
if(isset($_POST['value'])) {
    $v = array();
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['value'];
    $sql = "SELECT FunctionChild FROM decentralization WHERE IDMember='".$value."'";
    $query = mysqli_query($con, $sql);
    while ($row=mysqli_fetch_array($query))
    {
        $v[] =$row['FunctionChild'];
    }
    echo json_encode(['result'=>$v,'code'=>200,'query'=>$sql]);
}
else
    echo json_encode(['code'=>201]);