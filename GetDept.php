<?php
if(isset($_POST['result'])){
    $value = $_POST['result'];
    $con = "";
    $result= array();
    include ('Library/Connect_DB.php');
    $sql = "SELECT IDDept, NameDept FROM dept ORDER BY IDDept ASC";
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
