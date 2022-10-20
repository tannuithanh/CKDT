<?php
function GetIDEating($vt){
    $v='1';
    $con='';
    include ('Library/Connect_DB.php');
    $sql = "SELECT IDEating FROM eating WHERE VT='".$vt."'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $v = $row[0];
        }
    }
    return $v;
}
if(isset($_POST['result'])) {
    $v='';
    $con='';
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "DELETE FROM registeating WHERE DAY(TimeStamp)='".date('d')."' AND MONTH(TimeStamp)='".date('m')."' AND YEAR(TimeStamp)='".date('Y')."'";
    $querydelete = mysqli_query($con, $sql);
    $sql2="INSERT INTO registeating(IDMember, IDEating, IDTime,Work,OverTime) VALUES";
    for($i = 0 ;$i< count($value);$i++){
        $sql2 .= "('" . $value[$i]['idmember'] . "','" . GetIDEating($value[$i]['ideating']) . "','" . $value[$i]['idtime'] . "','" . $value[$i]['work'] . "','" . $value[$i]['timeover'] . "')";
        if($i!=(count($value)-1))
            $sql2.=",";
    }
    $query = mysqli_query($con, $sql2);
    echo json_encode(['result'=>"OK",'code'=>200,'TEST'=>$sql2,'valu'=>$value]);
}
else
    echo json_encode(['code'=>201]);
?>