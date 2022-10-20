<?php
if(isset($_POST['value'])) {
    $v='';
    $con='';
    include ('Library/Connect_DB.php');
    $value = $_POST['value'];
    $sql = "SELECT * FROM member WHERE IDMember='".$value['idmember']."'";
    $query = mysqli_query($con, $sql);
    if($query->num_rows==0) {
        if($value['admin']==true)
            $admin = 1;
        else
            $admin = 0;
        $sql = "INSERT INTO member(IDMember, FullName, IDDept, Pass, AdminUser) VALUES ('".$value['idmember']."','".$value['fullname']."','".$value['dept']."','".$value['pass']."','".$admin."')";
        $query = mysqli_query($con, $sql);
        echo json_encode(['result' => 'Insert', 'code' => 200, 'TEST' => $sql, 'valu' => $value]);
    }
    else
    {
        if($value['admin']==true    )
            $admin = 1;
        else
            $admin = 0;
        $sql = "UPDATE member set  FullName ='".$value['fullname']."', IDDept='".$value['dept']."', Pass='".$value['pass']."', AdminUser='".$admin."' WHERE IDMember='".$value['idmember']."'";
        $query = mysqli_query($con, $sql);
        echo json_encode(['result' => 'Update', 'code' => 200, 'TEST' => $sql, 'valu' => $value]);
    }
}
else
    echo json_encode(['code'=>201]);
?>