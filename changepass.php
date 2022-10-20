<?php
if(isset($_POST['result'])){
    $value = $_POST['result'];
    $con = "";
    // $result="";
    include ('Library/Connect_DB.php');
    $sql = "SELECT * FROM `member` WHERE IDMember ='".$value['msnv']."' AND Pass='".$value['pass_old']."'";
    // echo json_encode(['result1'=>$sql]);
    
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $sql1="UPDATE `member` SET `Pass`='".$value['pass_new2']."' WHERE IDMember ='".$value['msnv']."' AND Pass='".$value['pass_old']."'";
            $query1 = mysqli_query($con,$sql1);
            echo json_encode(['result'=>"OK",'code'=>200]);
        }
    }
    else{
        echo json_encode(['result'=>"NG",'code'=>200]);
    }
}
else echo json_encode(['code'=>201]);
?>