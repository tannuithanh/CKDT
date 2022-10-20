<?php
session_start();
if(isset($_POST['result'])) {
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "SELECT COUNT(*) as ct FROM eating WHERE NameEating = '".$value."'";
    $query = mysqli_query($con, $sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            if($row['ct']=="0") {
                $sql = "INSERT INTO eating (NameEating,VT) VALUES ('" . $value . "','" . substr($value, 0, 1) . "')";
                $query2 = mysqli_query($con, $sql);
                echo json_encode(['result'=>"OK",'code'=>200,'query'=>$sql]);
            }
            else
                echo json_encode(['result'=>"NOK",'code'=>200,'query'=>$sql]);
        }
    }
}
else
    echo json_encode(['code'=>201]);