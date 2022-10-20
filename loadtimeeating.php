<?php
session_start();
$v=array();
$con = "";
include ('Library/Connect_DB.php');
$value = $_POST['result'];
$sql = "SELECT id,TimeName FROM timeeating ORDER BY id ASC";
$query = mysqli_query($con, $sql);
if($query->num_rows>0){
    while($row=mysqli_fetch_array($query)){
        $v[] = $row;
    }
    echo json_encode(['result'=>$v,'code'=>200]);
}