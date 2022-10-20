<?php
if(isset($_POST['result'])){
    $value = $_POST['result'];
    $con = "";
    $result= "";
    $v="";
    include ('Library/Connect_DB.php');
    if($value['status']=='true') {
        $sql = "INSERT INTO decentralization(IDGroup, FunctionParent, FunctionChild) VALUES ('".$value['group']."','".$value['funtion']."','".$value['idfunction']."')";
        $query = mysqli_query($con, $sql);
        $v="insert";
    }
    else
    {
        $sql = "DELETE FROM decentralization WHERE IDGroup='".$value['group']."' AND FunctionParent='".$value['funtion']."' AND FunctionChild='".$value['idfunction']."'";
        $query = mysqli_query($con, $sql);
        $v="delete";
    }
    echo json_encode(['result'=>$value['status'],'kq'=>$v,'code'=>200]);
}
else echo json_encode(['code'=>201]);
?>
