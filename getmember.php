<?php
session_start();
if(isset($_POST['result'])) {
    $v=array();
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "SELECT member.IDMember, member.FullName,member.IDCard,dept.IDDept,dept.NameDept,position.IDPosition,position.NamePosition,position.IDGroup,member.MailAddress FROM member,dept,position,managermember WHERE managermember.IDMember = member.IDMember AND managermember.IDPosition = position.IDPosition AND  managermember.IDDept = dept.IDDept AND dept.IDDept='".$value."' ORDER BY position.IDPosition ASC";
    $query = mysqli_query($con, $sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $v[] = array("IDMember"=>$row['IDMember'],"FullName"=>$row['FullName'],"IDCard"=>$row['IDCard'],"NameDept"=>$row['NameDept'],"NamePosition"=>$row['NamePosition'],"Email"=>$row['MailAddress'],"Function"=>"<button class='settings' onclick='var idmember = ".'"'.$row['IDMember'].'"'.";;ShowEdit(idmember)' type='button' title data-toggle='tooltip' data-original-title='Cài đặt'><i class='material-icons' style='color: #3abaf4'>settings</i></button><button class='delete' onclick='var idmember = ".'"'.$row['IDMember'].'"'.";var fullname = ".'"'.$row['FullName'].'"'.";var result = {idmember,fullname}; DeleteMember(result) ' type='button' title data-toggle='tooltip' data-original-title='Xóa'><i class='material-icons' style='color: red'>delete</i></button>");
        }
        echo json_encode(['result'=>$v,'code'=>200,'query'=>$sql]);
    }
    else
        echo json_encode(['code'=>201,'query'=>$sql]);
}