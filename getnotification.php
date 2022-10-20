<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
$namedept = $_SESSION['NameDept'];
$iddept = $_SESSION['IDDept'];
$nameposition = $_SESSION['NamePosition'];
$idposition = $_SESSION['IDPosition'];
$idgroup = $_SESSION['IDGroup'];
function checkstatus($idfunction,$idfile)
{
    $con = "";
    include ('Library/Connect_DB.php');
    $numberapprove=0;
    $v="";
    $status="";
    $sql="SELECT NumberApprove FROM funtion WHERE IDFunction='".$idfunction."'";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        $numberapprove = $row['NumberApprove'];
    }
    $sql="SELECT COUNT(*) as ct FROM approve WHERE IDFile='".$idfile."' AND Approved=1";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        if($row['ct']==$numberapprove) {
            $v = "<span class='badge badge-success' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đã duyệt</span>";
            $status="S0003";
        }
        else {
            $v = "<span class='badge badge-warning' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đang duyệt</span>";
            $status="S0002";
        }
    }
    $sql ="SELECT * FROM approve WHERE IDFile='".$idfile."' AND Approved=0";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        if($_SESSION['idmember'] == $row['IDMember'])
        {
            if($row['No']>1) {
                $nonew = $row['No'] - 1;
                $sql = "SELECT COUNT(*) as ct FROM approve WHERE Approved=1 AND No='" .$nonew . "' AND IDFile='" . $idfile . "'";
                $query = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($query)) {
                    if ($row['ct'] > 0) {
                        $v = "<span class='badge badge-primary' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Cần duyệt</span>";
                        $status = "S0005";
                    }
                }
            }
            else
            {
                $v = "<span class='badge badge-primary' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Cần duyệt</span>";
                $status = "S0005";
            }
        }
    }
    $sql="SELECT Deny FROM managerfile WHERE IDFile='".$idfile."'";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        if($row['Deny']==1) {
            $v = "<span class='badge badge-danger' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đã từ chối</span>";
            $status="S0004";
        }
    }

    return array($v,$status);
}
if(isset($_POST['result'])) {
    $value = $_POST['result'];
    $v = 0;
    if ($idgroup == 'G0001') {
        $con = "";
        $id = "";
        include('Library/Connect_DB.php');
        if ($idgroup == 'G0001')
            $sql = "SELECT managerfile.IDFile,member.FullName,funtion.NameFunction,DATE_FORMAT(managerfile.Timestamp,'%H:%i:%s %d/%m/%Y') as Timestamp FROM managerfile,member,funtion,dept,managermember WHERE managerfile.IDMember=member.IDMember AND managerfile.IDFuntion = funtion.IDFunction AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND funtion.IDFunction in (SELECT funtion.IDFunction from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND member.IDMember='" . $idmember . "') ORDER BY managerfile.Timestamp DESC";
        else {
            $sql = "SELECT DISTINCT managerfile.IDFile,member.FullName,Dept.NameDept,funtion.NameFunction,DATE_FORMAT(managerfile.Timestamp,'%H:%i:%s %d/%m/%Y') as Timestamp FROM managerfile,member,funtion,dept,managermember WHERE managerfile.IDMember=member.IDMember AND managerfile.IDFuntion = funtion.IDFunction AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND (dept.IDDept = '" . $iddept . "' OR managerfile.IDFile IN (SELECT IDFile FROM approve WHERE IDMember='" . $idmember . "')) AND funtion.IDFunction in (SELECT funtion.IDFunction from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND member.IDMember='" . $idmember . "') ORDER BY managerfile.Timestamp DESC";
        }
        $query = mysqli_query($con, $sql);
        if ($query->num_rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $id = substr($row['IDFile'], 0, 5);
                $status = checkstatus(substr($row['IDFile'], 0, 5), $row['IDFile']);
                if ($status[1] == "S0005") {
                    $v++;
                }
            }
        }
    }
    else if ($idgroup !== 'G0006') {
        $con = "";
        include('Library/Connect_DB.php');
        $sql = "SELECT IDFile FROM managerfile WHERE IDMemberCreate = '" . $idmember . "' AND IDFile IN (SELECT IDFile FROM approve WHERE ShowNotify=0) ORDER BY Timestamp DESC";
        $query = mysqli_query($con, $sql);
        if ($query->num_rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $sql2 = "SELECT approve.IDFile,member.IDMember,approve.Approved,member.FullName,approve.Deny,approve.TimeStamp FROM approve,member WHERE member.IDMember = approve.IDMember AND approve.ShowNotify = 0 AND approve.Approved=1  AND approve.IDFile='" . $row['IDFile'] . "' ORDER BY approve.TimeStamp DESC";
                $query2 = mysqli_query($con, $sql2);
                if ($query2->num_rows > 0) {
                    while ($row2 = mysqli_fetch_array($query2)) {
                        $v++;
                    }
                }
            }
        }
    }

    echo json_encode(['result'=>$v,'code'=>200,'query'=>$idgroup]);
}
else
    echo json_encode(['code'=>201]);
