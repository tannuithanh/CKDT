<?php
if(isset($_POST['result'])){
    $value = $_POST['result'];
    $con = "";
    include ('Library/Connect_DB.php');
    $sql ="SELECT COUNT(*) as ct FROM member WHERE IDMember='".$value['idmember']."'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)) {
            if($row['ct']==0) {
                $sql = "INSERT INTO member(IDMember, FullName, Pass, AdminUser, MailAddress) VALUES ('".$value['idmember']."','".$value['fullname']."','123','0','".$value['mail']."')";
                $query2 = mysqli_query($con, $sql);
            }
        }
    }
    $sql = "SELECT COUNT(*) AS ct FROM managermember WHERE IDMember='".$value['idmember']."' AND IDDept='".$value['dept']."'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)) {
            if($row['ct']==0) {
                $sql = "INSERT INTO managermember(IDMember, IDDept, IDPosition) VALUES ('".$value['idmember']."','".$value['dept']."','".$value['position']."')";
                $query2 = mysqli_query($con, $sql);
            }
        }
    }
    echo json_encode(['result'=>"OK",'value'=>$value,'code'=>200]);
}
else echo json_encode(['code'=>201]);
?>
