<?php
session_start();
if(isset($_POST['result'])) {
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "SELECT COUNT(*) as ct FROM approvegvc WHERE Position1='" .$value['id1']. "' AND Position2='" .$value['id2']. "' AND Position3='" .$value['id3']. "'";
    $query = mysqli_query($con, $sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            if($row['ct']==0){
                $sql = "INSERT INTO approvegvc (Position1,Position2,Position3) VALUES ('" .$value['id1']. "','" .$value['id2']. "','" .$value['id3']. "')";
                $query2 = mysqli_query($con, $sql);
                echo json_encode(['result'=>"OK",'code'=>200,'TEST'=>$sql]);
            }
            else
                echo json_encode(['result'=>"TRUNG",'code'=>200,'TEST'=>$sql]);
        }
    }
    else
    echo json_encode(['result'=>"Loi",'code'=>200,'TEST'=>$sql]);
}
else
    echo json_encode(['code'=>201,'TEST'=>'NG']);
?>