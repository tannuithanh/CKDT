<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
function callcheck1($idfile, $idmember, $iddept)
{
    $con = "";
    $v = '';
    include('Library/Connect_DB.php');
    $sql = "SELECT member.IDMember,member.FullName FROM member,position,dept,managermember,approveptn WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND dept.IDDept='" . $iddept . "' AND position.IDPosition in (Select approveptn.Position2 FROM position,approveptn,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptn.Position1 AND member.IDMember='" . $idmember . "') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='" . $idfile . "')";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function callapprove($idfile, $idmember)
{
    $con = "";
    include('Library/Connect_DB.php');
    $sql = "SELECT member.IDMember,member.FullName FROM member,position,dept,managermember,approveptn WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approveptn.Position4 FROM position,approveptn,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptn.Position1 AND member.IDMember='" . $idmember . "') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='" . $idfile . "')";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function callkiemtra($idfile, $idmember)
{
    $con = "";
    include('Library/Connect_DB.php');
    $sql = "SELECT member.IDMember,member.FullName FROM member,position,dept,managermember,approveptn WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approveptn.Position3 FROM position,approveptn,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptn.Position1 AND member.IDMember='" . $idmember . "') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='" . $idfile . "')";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function callcheck2($idfile, $iddept)
{
    $con = "";
    $v = '';
    include('Library/Connect_DB.php');
    $sql = "SELECT member.IDMember,member.FullName FROM managermember,position,member WHERE managermember.IDMember = member.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup='G0002' AND managermember.IDDept='" . $iddept . "' AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='" . $idfile . "')";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function check($idfile, $idmember)
{
    $con = "";
    include('Library/Connect_DB.php');
    $sql = "SELECT TimeStamp,Approved,Deny,Note FROM approve WHERE IDFile='" . $idfile . "' AND IDMember='" . $idmember . "'";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function checkdept($id)
{
    $con = "";
    include('Library/Connect_DB.php');
    $v = '';
    $sql = "SELECT NameDept FROM dept WHERE IDDept='" . $id . "'";
    $query = mysqli_query($con, $sql);
    if ($query !== false && $query->num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $v = $row['NameDept'];
        }
    }
    return $v;
}

if (isset($_POST['result'])) {
    $value = $_POST['result']; //id cua File
    $con = "";
    include('Library/Connect_DB.php');
    $sql = "SELECT managerfile.IDFile,member.IDMember,dept.IDDept,dept.NameDept,phieuthunghiem.IDDept as IDDept2,phieuthunghiem.ThongtinSP,phieuthunghiem.Mucdichthunghiem,phieuthunghiem.Nguoitacnghiep,phieuthunghiem.Sdt,phieuthunghiem.Note,phieuthunghiem.Content,phieuthunghiem.Tieuchidanhgia,phieuthunghiem.Tieuchuanapdung,phieuthunghiem.Ghichu1,DATE_FORMAT(phieuthunghiem.TimeStamp,'%H:%i:%s %d/%m/%Y') as TimeStamp, DATE_FORMAT(phieuthunghiem.ngaytao,'Núi Thành, ngày %d tháng %m năm %Y') as ngaytao  FROM managerfile,member,phieuthunghiem,dept,managermember WHERE managerfile.IDFile = phieuthunghiem.IDFile AND managerfile.IDMember = member.IDMember AND member.IDMember = managermember.IDMember AND dept.IDDept = managermember.IDDept AND managerfile.IDFile='" . $value . "'";

    $query = mysqli_query($con, $sql);
    $result = [];

    if ($query->num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $v = array("IDFile" => $row['IDFile'], "NameDept" => $row['NameDept'], "TimeStamp" => $row['TimeStamp'], "ngaytao" => $row['ngaytao'], "ThongtinSP" => $row['ThongtinSP'], "Mucdichthunghiem" => $row['Mucdichthunghiem'], "Nguoitacnghiep" => $row['Nguoitacnghiep'], "Sdt" => $row['Sdt'], "Note" => $row['Note'], "Content" => $row['Content'], "Tieuchidanhgia" => $row['Tieuchidanhgia'], "Tieuchuanapdung" => $row['Tieuchuanapdung'], "Ghichu1" => $row['Ghichu1'], "DeptNeed" => checkdept($row['IDDept2']), "Check1" => callcheck1($row['IDFile'], $row['IDMember'], $row['IDDept']), "Checked1" => check($row['IDFile'], callcheck1($row['IDFile'], $row['IDMember'], $row['IDDept'])['IDMember']), "Kiemtra" => callkiemtra($row['IDFile'], $row['IDMember'], $row['IDDept']),"Kiemtraked" => check($row['IDFile'], callkiemtra($row['IDFile'], $row['IDMember'], $row['IDDept'])['IDMember']), "Check2" => callcheck2($row['IDFile'], $row['IDDept2']), "Checked2" => check($row['IDFile'], callcheck2($row['IDFile'], $row['IDDept2'])['IDMember']), "Approve" => callapprove($row['IDFile'], $row['IDMember']), "Approved" => check($row['IDFile'], callapprove($row['IDFile'], $row['IDMember'])['IDMember']));

            $result[] = $v;
        }
        echo json_encode(['result' => $v, 'code' => 200, 'query' => $sql, 'final_result' => $result]);
    } else echo json_encode(['code' => 201, 'query' => $sql]);
} else
    echo json_encode(['code' => 201]);
