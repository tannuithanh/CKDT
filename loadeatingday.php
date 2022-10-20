<?php
session_start();
if(isset($_POST['result'])) {
    $v=array();
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "SELECT eating.NameEating,COUNT(registeating.IDEating) FROM registeating,eating,member WHERE registeating.IDMember = member.IDMember and eating.IDEating = registeating.IDEating AND registeating.Work=1 AND DAY(registeating.TimeStamp)='" . date('d') . "' AND MONTH(registeating.TimeStamp)='" . date('m') . "' AND YEAR(registeating.TimeStamp)='" . date('Y') . "' AND registeating.IDTime='" . $value . "' GROUP BY registeating.IDEating";
        $query = mysqli_query($con, $sql);
        if ($query->num_rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $v[] = $row;
            }
            echo json_encode(['result' => $v, 'code' => 200]);
        } else echo json_encode(['result' => $v, 'code' => 200]);
}
else
    echo json_encode(['code'=>201]);