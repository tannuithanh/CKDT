<?php

function CheckAllow($v){
    $con = "";
    $result= array();
    include ('Library/Connect_DB.php');
    $value = false;
    $sql = "SELECT COUNT(*) AS ct FROM decentralization,funtion WHERE decentralization.FunctionChild = funtion.IDFunction AND decentralization.IDGroup='".$v[0]."' AND decentralization.FunctionParent='".$v[1]."' AND decentralization.FunctionChild='".$v[2]."'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            if($row['ct']>0)
                $value = true;
            else $value = false;
        }
    }
    return $value;
}

if(isset($_POST['result'])){
    $value = $_POST['result'];
    $con = "";
    $result= array();
    include ('Library/Connect_DB.php');
    $sql = "SELECT funtion.IDFunction,funtion.NameFunction FROM parentchild,funtion WHERE funtion.IDFunction = parentchild.FunctionChild AND parentchild.FunctionParent='".$value['funtion']."' ORDER BY funtion.IDFunction ASC";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $v = array($value['group'],$value['funtion'],$row['IDFunction']);
            $result[] = array("IDFunction"=>$row['IDFunction'],"NameFunction"=>$row['NameFunction'],"checked"=>CheckAllow($v));
        }
    }
    echo json_encode(['result'=>$result,'code'=>200]);
}
else echo json_encode(['code'=>201]);
?>
