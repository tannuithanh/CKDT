<?php
if(isset($_POST['result'])){
    $value = $_POST['result'];
    $con = "";
    $result= array();
    include ('Library/Connect_DB.php');
    $sql = "SELECT DISTINCT funtion.IDFunction,funtion.NameFunction FROM decentralization,funtion WHERE decentralization.FunctionParent = funtion.IDFunction AND decentralization.IDGroup='".$value."' ORDER BY funtion.IDFunction ASC";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $result[] = $row;
        }
    }
    echo json_encode(['result'=>$result,'code'=>200]);
}
else echo json_encode(['code'=>201]);
?>
