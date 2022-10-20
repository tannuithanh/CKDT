<?php
session_start();
$idmember = $_SESSION['idmember'];
$namedept = $_SESSION['NameDept'];
$iddept = $_SESSION['IDDept'];
$nameposition = $_SESSION['NamePosition'];
$idposition = $_SESSION['IDPosition'];
$idgroup = $_SESSION['IDGroup'];
function checknamefunction($id)
{
    $con = "";
    include('Library/Connect_DB.php');
    $v="";
    $sql="SELECT NameFunction FROM funtion WHERE IDFunction='".$id."'";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        $v=$row['NameFunction'];
    }
    return $v;
}
function checkstatus($idfunction,$idfile)
{
    $con = "";
    include('Library/Connect_DB.php');
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
                $nonew = $row['No']-1;
                $sql = "SELECT COUNT(*) as ct FROM approve WHERE Approved=1 AND No='" . $nonew . "' AND IDFile='" . $idfile . "'";
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
    $notify = array();
    $show = 0;
    $show2 = 0;
    if ($idgroup == 'G0001') {
        $con = "";
        $id = "";
        include('Library/Connect_DB.php');
        if ($idgroup == 'G0001')
            $sql = "SELECT managerfile.IDFile,member.FullName,Dept.NameDept,funtion.NameFunction,managerfile.Timestamp FROM managerfile,member,funtion,dept,managermember WHERE managerfile.IDMember=member.IDMember AND managerfile.IDFuntion = funtion.IDFunction AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND funtion.IDFunction in (SELECT funtion.IDFunction from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND member.IDMember='" . $idmember . "') ORDER BY managerfile.Timestamp DESC";
        else {
            $sql = "SELECT DISTINCT managerfile.IDFile,member.FullName,Dept.NameDept,funtion.NameFunction,managerfile.Timestamp FROM managerfile,member,funtion,dept,managermember WHERE managerfile.IDMember=member.IDMember AND managerfile.IDFuntion = funtion.IDFunction AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND (dept.IDDept = '" . $iddept . "' OR managerfile.IDFile IN (SELECT IDFile FROM approve WHERE IDMember='" . $idmember . "')) AND funtion.IDFunction in (SELECT funtion.IDFunction from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND member.IDMember='" . $idmember . "') ORDER BY managerfile.Timestamp DESC";
        }
        $query = mysqli_query($con, $sql);
        if ($query->num_rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $id = substr($row['IDFile'], 0, 5);
                $status = checkstatus(substr($row['IDFile'], 0, 5), $row['IDFile']);
                if ($status[1] == "S0005") {
                    $show = 1;
                    $link = "http://113.161.6.179:8089/RD/" . $id . ".php?id=" . $row['IDFile'] . "";
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $currenday = date('Y-m-d\TH:i');
                    $day = (strtotime($currenday) - strtotime($row['Timestamp']));
                    if($day<=0)
                        $notify[] = array("FullName" => $row['FullName']." - ".$row['NameDept'], "Time" => "0 giây", "Link" => $link, "NameFunction" => "trình duyệt " . checknamefunction($id));
                    else if ($day < 60)
                        $notify[] = array("FullName" => $row['FullName']." - ".$row['NameDept'], "Time" => $day . " giây", "Link" => $link, "NameFunction" => "trình duyệt " . checknamefunction($id));
                    else if (floor($day / 60) < 60)
                        $notify[] = array("FullName" => $row['FullName']." - ".$row['NameDept'], "Time" => floor($day / 60) . " phút", "Link" => $link, "NameFunction" => "trình duyệt " . checknamefunction($id));
                    else if (floor($day / (60 * 60)) < 24)
                        $notify[] = array("FullName" => $row['FullName']." - ".$row['NameDept'], "Time" => floor($day / (60 * 60)) . " giờ", "Link" => $link, "NameFunction" => "trình duyệt " . checknamefunction($id));
                    else $notify[] = array("FullName" => $row['FullName']." - ".$row['NameDept'], "Time" => floor($day / (60 * 60 * 24)) . " ngày", "Link" => $link, "NameFunction" => "trình duyệt " . checknamefunction($id));
                }
            }
        }
    } else if ($idgroup !== 'G0006') {
        $con = "";
        include('Library/Connect_DB.php');
        $sql = "SELECT IDFile FROM managerfile WHERE IDMemberCreate = '" . $idmember . "' AND IDFile IN (SELECT IDFile FROM approve WHERE ShowNotify=0) ORDER BY Timestamp DESC";
        $query = mysqli_query($con, $sql);
        if ($query->num_rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $sql2 = "SELECT approve.IDFile,member.IDMember,approve.Approved,member.FullName,approve.Deny,approve.TimeStamp FROM approve,member WHERE member.IDMember = approve.IDMember AND ShowNotify = 0 AND approve.IDFile='" . $row['IDFile'] . "' ORDER BY approve.TimeStamp DESC";
                $query2 = mysqli_query($con, $sql2);
                if ($query2->num_rows > 0) {
                    while ($row2 = mysqli_fetch_array($query2)) {
                        $show = 1;
                        $show2 = 1;
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $currenday = date('Y-m-d\TH:i');
                        $day = (strtotime($currenday) - strtotime($row2['TimeStamp']));
                        $id = substr($row2['IDFile'], 0, 5);
                        $link = "http://113.161.6.179:8089/RD/" . $id . ".php?id=" . $row['IDFile'] . "";
                        if ($row2['Approved'] == 1) {
                            if($day<=0)
                                $notify[] = array("IDFile" => $row2['IDFile'], "IDMember" => $row2['IDMember'], "FullName" => $row2['FullName'], "Time" => "0 giây", "Link" => $link, "NameFunction" => "đã duyệt " . checknamefunction($id));
                             else if ($day < 60)
                                $notify[] = array("IDFile" => $row2['IDFile'], "IDMember" => $row2['IDMember'], "FullName" => $row2['FullName'], "Time" => $day . " giây", "Link" => $link, "NameFunction" => "đã duyệt " . checknamefunction($id));
                            else if (floor($day / 60) < 60)
                                $notify[] = array("IDFile" => $row2['IDFile'], "IDMember" => $row2['IDMember'], "FullName" => $row2['FullName'], "Time" => floor($day / 60) . " phút", "Link" => $link, "NameFunction" => "đã duyệt " . checknamefunction($id));
                            else if (floor($day / (60 * 60)) < 24)
                                $notify[] = array("IDFile" => $row2['IDFile'], "IDMember" => $row2['IDMember'], "FullName" => $row2['FullName'], "Time" => floor($day / (60 * 60)) . " giờ", "Link" => $link, "NameFunction" => "đã duyệt " . checknamefunction($id));
                            else $notify[] = array("IDFile" => $row2['IDFile'], "IDMember" => $row2['IDMember'], "FullName" => $row2['FullName'], "Time" => floor($day / (60 * 60 * 24)) . " ngày", "Link" => $link, "NameFunction" => "đã duyệt " . checknamefunction($id));
                        }
                        if ($row2['Deny'] == 1) {
                            if($day<=0)
                                $notify[] = array("IDFile" => $row2['IDFile'], "IDMember" => $row2['IDMember'], "FullName" => $row2['FullName'], "Time" => "0 giây", "Link" => $link, "NameFunction" => "đã duyệt " . checknamefunction($id));
                            else if ($day < 60)
                                $notify[] = array("IDFile" => $row2['IDFile'], "IDMember" => $row2['IDMember'], "FullName" => $row2['FullName'], "Time" => $day . " giây", "Link" => $link, "NameFunction" => "đã từ chối " . checknamefunction($id));
                            else if (floor($day / 60) < 60)
                                $notify[] = array("IDFile" => $row2['IDFile'], "IDMember" => $row2['IDMember'], "FullName" => $row2['FullName'], "Time" => floor($day / 60) . " phút", "Link" => $link, "NameFunction" => "đã từ chối " . checknamefunction($id));
                            else if (floor($day / (60 * 60)) < 24)
                                $notify[] = array("IDFile" => $row2['IDFile'], "IDMember" => $row2['IDMember'], "FullName" => $row2['FullName'], "Time" => floor($day / (60 * 60)) . " giờ", "Link" => $link, "NameFunction" => "đã từ chối " . checknamefunction($id));
                            else $notify[] = array("IDFile" => $row2['IDFile'], "IDMember" => $row2['IDMember'], "FullName" => $row2['FullName'], "Time" => floor($day / (60 * 60 * 24)) . " ngày", "Link" => $link, "NameFunction" => "đã từ chối " . checknamefunction($id));
                        }
                    }
                }
            }
        }
    }
    $value = array($notify,$show,$show2);
    echo json_encode(['result'=>$value,'code'=>200,'query'=>$sql]);
}
else
    echo  json_encode(['code'=>201]);
?>