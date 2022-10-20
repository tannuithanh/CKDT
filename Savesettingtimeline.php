<?php
if(isset($_POST['result'])){
$con = "";
include ('Library/Connect_DB.php');
$value = $_POST['result'];
$startime = date("Y/m/d")." ".$value['timestart'];
$endtime = date("Y/m/d")." ".$value['timeend'];
$sql = 'UPDATE timeeating SET StartTime="'.$startime.'",EndTime="'.$endtime.'" WHERE id="'.$value['value'].'"';
$query = mysqli_query($con, $sql);
echo json_encode(['result'=>$startime,'code'=>200]);
}
else echo json_encode(['code'=>201]);