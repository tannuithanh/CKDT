<?php
session_start();
$v=array();
$con = "";
include ('Library/Connect_DB.php');
$value = $_POST['result'];
$sql = "SELECT IDEating, NameEating,VT FROM eating ORDER BY IDEating ASC";
$query = mysqli_query($con, $sql);
if($query->num_rows>0){
    while($row=mysqli_fetch_array($query)){
        $v[] = $row;
    }
    echo json_encode(['result'=>$v,'code'=>200]);
}