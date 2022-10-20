<?php
session_start();
if(isset($_POST['result'])) {
    $v=array();
    $con = "";
    include ('Library/Connect_DB.php');
    $sql2 = "SELECT IDEating,NameEating FROM eating ORDER BY IDEating ASC";
    $query = mysqli_query($con, $sql2);
    while($row=mysqli_fetch_array($query)){
        $data[] = $row;
    }
    $value = $_POST['result'];
    $sql = "SELECT member.IDMember, member.FullName,position.NamePosition,registeating.Work,eating.NameEating,registeating.OverTime FROM member,dept,position,managermember,registeating,eating WHERE  eating.IDEating = registeating.IDEating AND registeating.IDMember = member.IDMember AND managermember.IDMember = member.IDMember AND managermember.IDPosition = position.IDPosition AND  managermember.IDDept = dept.IDDept AND dept.IDDept='".$value['dept']."' AND DAY(registeating.TimeStamp)='".date('d')."' AND MONTH(registeating.TimeStamp)='".date('m')."' AND registeating.IDTime='".$value['time']."' AND YEAR(registeating.TimeStamp)='".date('Y')."' ORDER BY position.IDPosition ASC";
    $query3 = mysqli_query($con,$sql);
    if($query3->num_rows>0){
        while ($row = mysqli_fetch_array($query3)){
            if($row['Work']==0) {
                $yes = '<input class="text-sm mb-0 form-check-input mt-0 border" type="checkbox" value="" disabled>';
                $ma = "";
            }
            else {
                $yes = '<input class="text-sm mb-0 form-check-input mt-0 border" type="checkbox" checked value="" disabled>';
                $ma =$row['NameEating'];
            }
            if($row['OverTime'] =="" || $row['OverTime']=="N/a")
                $note = "";
            else
                $note = "Tăng ca ".$row['OverTime'];
            $v[] = array("IDMember" => $row['IDMember'], "FullName" => $row['FullName'], "NamePosition" => $row['NamePosition'], "MA" => $ma,"Work"=>$yes,"note"=>$note);
        }
        echo json_encode(['result' => $v, 'code' => 200]);
    }
    else {
        $sql2 = "SELECT member.IDMember, member.FullName,member.IDCard,dept.IDDept,dept.NameDept,position.IDPosition,position.NamePosition,position.IDGroup,member.MailAddress FROM member,dept,position,managermember WHERE managermember.IDMember = member.IDMember AND managermember.IDPosition = position.IDPosition AND  managermember.IDDept = dept.IDDept AND dept.IDDept='" . $value['dept'] . "' ORDER BY position.IDPosition ASC";
        $query = mysqli_query($con, $sql2);
        if ($query->num_rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $select = '<select class="selecteating nav-link dropdown-toggle" style="width: 100%">';
                foreach ($data as $va) {
                    $select .= '<option value="' . trim($va['IDEating']) . '">' . $va['NameEating'] . '</option>';
                }
                $select .= '</select>';
                $v[] = array("IDMember" => $row['IDMember'], "FullName" => $row['FullName'], "IDCard" => $row['IDCard'], "NameDept" => $row['NameDept'], "NamePosition" => $row['NamePosition'],"Work"=>'<input type="checkbox" checked>', "MA" => $select,"note"=>"");
            }
            echo json_encode(['result' => $v, 'code' => 200, 'query' => $sql]);
        } else
            echo json_encode(['code' => 201, 'query' => $sql]);
    }
}