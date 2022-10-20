<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
function callcheck($idfile,$idmember,$iddept)
{
    $con = "";
    include ('Library/Connect_DB.php');
    $sql="SELECT member.IDMember,member.FullName FROM member, approve WHERE member.IDMember=approve.IDMember AND approve.No=1 AND approve.IDFile='".$idfile."'";
    // $sql="SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvegrc WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvegrc.Position2 FROM position,approvegrc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvegrc.Position1 AND member.IDMember='".$idmember."') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        $v= $row;
    }
    return $v;
}
function callapprove($idfile,$idmember)
{
    $con = "";
    include('Library/Connect_DB.php');
    $sql="SELECT member.IDMember,member.FullName FROM member, approve WHERE member.IDMember=approve.IDMember AND approve.No=2 AND approve.IDFile='".$idfile."'";
    // $sql = "SELECT member.IDMember,member.FullName FROM member,position,dept,managermember,approvegrc WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvegrc.Position3 FROM position,approvegrc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvegrc.Position1 AND member.IDMember='".$idmember."') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
     return $v;
}
function check($idfile,$idmember)
{
    $con = "";
    include('Library/Connect_DB.php');
    $sql = "SELECT TimeStamp,Approved,Deny,Note FROM approve WHERE IDFile='".$idfile."' AND IDMember='".$idmember."'";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }  
    return $v;
}
if(isset($_POST['result'])) {
    $value = $_POST['result'];
    $con = "";
    $id="";
    include ('Library/Connect_DB.php');
    $sql = "SELECT managerfile.IDFile,managerfile.Deny,member.IDMember,member.FullName,dept.IDDept,dept.NameDept,DATE_FORMAT(grc.TimeStampOut,'%H:%i:%s %d/%m/%Y') as TimeStampOut,DATE_FORMAT(grc.TimeStampIn,'%H:%i:%s %d/%m/%Y') as TimeStampIn,grc.Reason,grc.LicensePlates,grc.Bring,grc.Note FROM managerfile,member,dept,managermember,position,grc WHERE member.IDMember = managerfile.IDMember AND member.IDMember = managermember.IDMember AND dept.IDDept = managermember.IDDept AND position.IDPosition = managermember.IDPosition AND managerfile.IDFile = grc.IDFile AND managerfile.IDFile='".$value."'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $v = array("IDFile"=>$row['IDFile'],"Deny"=>$row['Deny'],"FullName"=>$row['FullName'],"NameDept"=>$row['NameDept'],"TimeStampOut"=>$row['TimeStampOut'],"TimeStampIn"=>$row['TimeStampIn'],"Reason"=>$row['Reason'],"LicensePlates"=>$row['LicensePlates'],"Bring"=>$row['Bring'],"Note"=>$row['Note'],"Check"=>callcheck($row['IDFile'],$row['IDMember'],$row['IDDept']),"Checked"=>check($row['IDFile'],callcheck($row['IDFile'],$row['IDMember'],$row['IDDept'])['IDMember']),"Approve"=>callapprove($row['IDFile'],$row['IDMember']),"Approved"=> check($row['IDFile'],callapprove($row['IDFile'],$row['IDMember'])['IDMember']));
        }
         echo json_encode(['result'=>$v,'code'=>200,'query'=>$id]);
    }
}
else
    echo json_encode(['code'=>201]);
