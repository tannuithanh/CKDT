<?php
session_start();
if(isset($_POST['result'])) {
    $v=array();
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "SELECT dept.NameDept,dept.IDDept,COUNT(managermember.IDMember) FROM managermember,dept WHERE managermember.IDDept = dept.IDDept GROUP BY dept.IDDept ORDER BY dept.IDDept ASC";
        $query = mysqli_query($con, $sql);
        if ($query->num_rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $sql = "SELECT COUNT(*) as ct FROM registeating,managermember WHERE managermember.IDMember = registeating.IDMember AND registeating.Work=1  AND managermember.IDDept='".$row[1]."' AND registeating.IDTime='" . $value . "' AND DAY(registeating.TimeStamp)='".date('d')."' AND MONTH(registeating.TimeStamp)='".date('m')."' AND YEAR(registeating.TimeStamp)='".date('Y')."'";
                $query2 = mysqli_query($con, $sql);
                $row2 = mysqli_fetch_array($query2);
                $vang = (int)$row[2]-(int)$row2['ct'];
                $v[] = array($row[0],$row[2],$row2['ct'],$vang);
            }
            echo json_encode(['result' => $v, 'code' => 200]);
        } else echo json_encode(['result' => $v, 'code' => 200]);
}
else
    echo json_encode(['code'=>201]);