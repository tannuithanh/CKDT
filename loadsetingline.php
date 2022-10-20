<?php
session_start();
$v;
$con = "";
include ('Library/Connect_DB.php');
$value = $_POST['value'];
$sql = 'SELECT DATE_FORMAT(StartTime,"%H:%i") as StartTime,DATE_FORMAT(EndTime,"%H:%i") as EndTime FROM timeeating WHERE id="'.$value.'"';
$query = mysqli_query($con, $sql);
if($query->num_rows>0){
    while($row=mysqli_fetch_array($query)){
        $v = $row;
    }
    echo json_encode(['result'=>$v,'code'=>200]);
}