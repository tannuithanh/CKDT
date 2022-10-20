<?php
if(isset($_POST['result'])) {
    $v='';
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "SELECT position.OutDept FROM position,member,managermember WHERE member.IDMember = managermember.IDMember AND position.IDPosition = managermember.IDPosition AND member.IDMember='".$value['idmember']."'";
    $query = mysqli_query($con, $sql);
    if($query->num_rows>0){
        while($row=$query->fetch_all(MYSQLI_ASSOC)){
            if($row[0]["OutDept"]==0){
                $sql2 = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvegrc WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvegrc.Position2 FROM position,approvegrc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvegrc.Position1 AND member.IDMember='".$value['idmember']."') ORDER BY position.IDPosition ASC";
               // $sql2 = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvegrc WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND dept.IDDept='".$value['iddept']."' AND position.IDPosition in (Select approvegrc.Position2 FROM position,approvegrc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvegrc.Position1 AND member.IDMember='".$value['idmember']."') ORDER BY position.IDPosition ASC";
                $query2 = mysqli_query($con, $sql2);
                if($query2->num_rows>0){
                    while($row2=$query2->fetch_all(MYSQLI_ASSOC)){
                        $v = $row2;
                        echo json_encode(['result'=>$v,'code'=>200]);
                    }
                }
            }
            else{
                $sql3 = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvegrc WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvegrc.Position2 FROM position,approvegrc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvegrc.Position1 AND member.IDMember='".$value['idmember']."') ORDER BY position.IDPosition ASC";
                $query3 = mysqli_query($con, $sql3);
                if($query3->num_rows>0){
                    while($row3=$query3->fetch_all(MYSQLI_ASSOC)){
                        $v = $row3;
                        echo json_encode(['result'=>$v,'code'=>200]);
                    }
                }
            }
        }
    }
}
else
    echo json_encode(['code'=>201]);